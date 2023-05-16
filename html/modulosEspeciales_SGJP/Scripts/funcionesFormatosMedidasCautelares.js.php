<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$idCarpeta=$_GET["iC"];
	$carpetaAdministrativa=$_GET["c"];
	
	$consulta="SELECT idActividad,id__17_tablaDinamica FROM 7006_carpetasAdministrativas c,_17_tablaDinamica u 
				WHERE carpetaAdministrativa='".$carpetaAdministrativa."' and u.claveUnidad=c.unidadGestion";
	if($idCarpeta!=-1)
	{
		$consulta.=" AND idCarpeta=".$idCarpeta;
	}
	$fCarpeta=$con->obtenerPrimeraFila($consulta);
	
	$idActividad=$fCarpeta[0];
	$iUG=$fCarpeta[1];
	
	$consulta="SELECT usuarioJuez,u.Nombre FROM _26_tablaDinamica j,800_usuarios u WHERE idReferencia=".$iUG.
				" AND u.idUsuario=j.usuarioJuez and j.usuarioJuez<>3122 ORDER BY u.Nombre";
	$arrJueces=$con->obtenerFilasArreglo($consulta);
	
	$fechaActual=date("Y-m-d");
	$consulta="SELECT idRegistroEvento,
			concat(date_format(fechaEvento,'%d/%m/%Y'),' - ',date_format(horaInicioEvento,'%H:%i'),' ',(SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=e.tipoAudiencia)) AS etAudiencia,
			fechaEvento,horaInicioEvento, 
			(SELECT replace(tipoAudiencia,'audiencia ','') FROM _4_tablaDinamica WHERE id__4_tablaDinamica=e.tipoAudiencia) as tAudiencia,
			(SELECT replace(nombreSala,'Sala ','') FROM _15_tablaDinamica WHERE id__15_tablaDinamica=e.idSala) as sala
			FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa c 
			WHERE c.carpetaAdministrativa='".$carpetaAdministrativa."' and c.idCarpetaAdministrativa in (-1,".$idCarpeta.
			") AND c.tipoContenido=3 AND c.idRegistroContenidoReferencia=e.idRegistroEvento 
			AND e.situacion IN(0,1,2,4,5) and e.fechaEvento<='".$fechaActual."' ORDER BY e.fechaEvento DESC,e.horaInicioEvento DESC";
	
	$arrAudiencias=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT id__47_tablaDinamica,CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno)) 
				FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica
				AND r.idActividad=".$idActividad." AND r.idFiguraJuridica=4 ORDER BY nombre,nombre,apellidoMaterno";
				
	$arrImputados=$con->obtenerFilasArreglo($consulta);
	
	
	$puestosFirmantes="15,40,41";
	
	$consulta="SELECT idPadre FROM _420_unidadGestion WHERE idOpcion=".$iUG;
	$idPerfil=$con->obtenerValor($consulta);
	if($idPerfil=="")
		$idPerfil=-1;
	
	
	$consulta=" SELECT id__421_tablaDinamica,CONCAT(
 IF((SELECT nombre FROM 800_usuarios WHERE idUsuario=usuarioAsignado) IS NULL,'(NO asignado)',
 (SELECT nombre FROM 800_usuarios WHERE idUsuario=usuarioAsignado) ),' 
 (',(SELECT nombrePuesto FROM _416_tablaDinamica WHERE id__416_tablaDinamica=puestoOrganozacional),')')  AS usuario
				FROM _421_tablaDinamica WHERE idReferencia=".$idPerfil." AND puestoOrganozacional IN(".$puestosFirmantes.")";

	$arrFirmantes=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta=" SELECT id__421_tablaDinamica,CONCAT(
 IF((SELECT nombre FROM 800_usuarios WHERE idUsuario=usuarioAsignado) IS NULL,'(NO asignado)',
 (SELECT nombre FROM 800_usuarios WHERE idUsuario=usuarioAsignado) ),' 
 (',(SELECT nombrePuesto FROM _416_tablaDinamica WHERE id__416_tablaDinamica=puestoOrganozacional),')')  AS usuario
				FROM _421_tablaDinamica WHERE idReferencia=".$idPerfil." AND puestoOrganozacional=35";

	$judNotificadores=$con->obtenerValor($consulta);
	if($judNotificadores=="")
		$judNotificadores=-1;
	
	
	$consulta="SELECT id__587_tablaDinamica,leyenda,fraccion FROM _587_tablaDinamica WHERE materiaRegistro=2 AND tipoRegistro=1 ORDER BY cveSistemaUSMECA";
	$arrMedidasCautelaresAdolescentes="";
	
	$resRegistro=$con->obtenerFilas($consulta);
	while($fRegistro=mysql_fetch_row($resRegistro))
	{
		$oRegistro="['".$fRegistro[0]."','".cv(strip_tags($fRegistro[2].".- ".$fRegistro[1]))."','".$fRegistro[2]."']";
		if($arrMedidasCautelaresAdolescentes=="")
			$arrMedidasCautelaresAdolescentes=$oRegistro;
		else
			$arrMedidasCautelaresAdolescentes.=",".$oRegistro;
	}
	$arrMedidasCautelaresAdolescentes="[".$arrMedidasCautelaresAdolescentes."]";
	
	$consulta="SELECT id__587_tablaDinamica,leyenda,fraccion FROM _587_tablaDinamica WHERE materiaRegistro=2 AND tipoRegistro=2 ORDER BY cveSistemaUSMECA";
	$arrCondicionesSCAdolescentes="";
	$resRegistro=$con->obtenerFilas($consulta);
	while($fRegistro=mysql_fetch_row($resRegistro))
	{
		$oRegistro="['".$fRegistro[0]."','".cv(strip_tags($fRegistro[2].".- ".$fRegistro[1]))."','".$fRegistro[2]."']";
		if($arrCondicionesSCAdolescentes=="")
			$arrCondicionesSCAdolescentes=$oRegistro;
		else
			$arrCondicionesSCAdolescentes.=",".$oRegistro;
	}
	$arrCondicionesSCAdolescentes="[".$arrCondicionesSCAdolescentes."]";
	
	
	$consulta="SELECT id__587_tablaDinamica,leyenda,fraccion FROM _587_tablaDinamica WHERE materiaRegistro=2 AND tipoRegistro=3 ORDER BY cveSistemaUSMECA";
	$arrMedidasCautelaresAdolescentesUGA="";
	
	$resRegistro=$con->obtenerFilas($consulta);
	while($fRegistro=mysql_fetch_row($resRegistro))
	{
		$oRegistro="['".$fRegistro[0]."','".cv(strip_tags($fRegistro[1]))."','".$fRegistro[2]."']";
		if($arrMedidasCautelaresAdolescentesUGA=="")
			$arrMedidasCautelaresAdolescentesUGA=$oRegistro;
		else
			$arrMedidasCautelaresAdolescentesUGA.=",".$oRegistro;
	}
	$arrMedidasCautelaresAdolescentesUGA="[".$arrMedidasCautelaresAdolescentesUGA."]";
	
	$consulta="SELECT id__587_tablaDinamica,leyenda,fraccion FROM _587_tablaDinamica WHERE materiaRegistro=2 AND tipoRegistro=4 ORDER BY cveSistemaUSMECA";
	$arrCondicionesSCAdolescentesUGA="";
	$resRegistro=$con->obtenerFilas($consulta);
	while($fRegistro=mysql_fetch_row($resRegistro))
	{
		$oRegistro="['".$fRegistro[0]."','".cv(strip_tags($fRegistro[1]))."','".$fRegistro[2]."']";
		if($arrCondicionesSCAdolescentesUGA=="")
			$arrCondicionesSCAdolescentesUGA=$oRegistro;
		else
			$arrCondicionesSCAdolescentesUGA.=",".$oRegistro;
	}
	$arrCondicionesSCAdolescentesUGA="[".$arrCondicionesSCAdolescentesUGA."]";
	
	
	$consulta="SELECT id__587_tablaDinamica,leyenda,fraccion FROM _587_tablaDinamica WHERE materiaRegistro=1 AND tipoRegistro=2 ORDER BY cveSistemaUSMECA";
	$arrCondicionesSCAdultosUGA="";
	$resRegistro=$con->obtenerFilas($consulta);
	while($fRegistro=mysql_fetch_row($resRegistro))
	{
		$oRegistro="['".$fRegistro[0]."','".$fRegistro[2].".- ".cv(strip_tags($fRegistro[1]))."','".$fRegistro[2]."']";
		if($arrCondicionesSCAdultosUGA=="")
			$arrCondicionesSCAdultosUGA=$oRegistro;
		else
			$arrCondicionesSCAdultosUGA.=",".$oRegistro;
	}
	$arrCondicionesSCAdultosUGA="[".$arrCondicionesSCAdultosUGA."]";
	
	$consulta="SELECT id__587_tablaDinamica,leyenda,fraccion FROM _587_tablaDinamica WHERE materiaRegistro=1 AND tipoRegistro=1 ORDER BY cveSistemaUSMECA";
	$arrMedidasCautelaresAdultos="";
	$resRegistro=$con->obtenerFilas($consulta);
	while($fRegistro=mysql_fetch_row($resRegistro))
	{
		$oRegistro="['".$fRegistro[0]."','".$fRegistro[2].".- ".cv(strip_tags($fRegistro[1]))."','".$fRegistro[2]."']";
		if($arrMedidasCautelaresAdultos=="")
			$arrMedidasCautelaresAdultos=$oRegistro;
		else
			$arrMedidasCautelaresAdultos.=",".$oRegistro;
	}
	
	$arrMedidasCautelaresAdultos="[".$arrMedidasCautelaresAdultos."]";
	
	$arrCondicionesSCAdultos="";
	$consulta="SELECT id__587_tablaDinamica,leyenda,fraccion FROM _587_tablaDinamica WHERE materiaRegistro=1 AND tipoRegistro=2 ORDER BY id__587_tablaDinamica";
	$resRegistro=$con->obtenerFilas($consulta);

	while($fRegistro=mysql_fetch_row($resRegistro))
	{
		$oRegistro="['".$fRegistro[0]."','".cv(strip_tags($fRegistro[1]))."','".$fRegistro[2]."']";
		if($arrCondicionesSCAdultos=="")
			$arrCondicionesSCAdultos=$oRegistro;
		else
			$arrCondicionesSCAdultos.=",".$oRegistro;
	}
	
	$arrCondicionesSCAdultos="[".$arrCondicionesSCAdultos."]";
	
	$consulta="SELECT idRegistroEvento	FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa c 
			WHERE c.carpetaAdministrativa='".$carpetaAdministrativa."' and c.idCarpetaAdministrativa in (-1,".$idCarpeta.
			") AND c.tipoContenido=3 AND c.idRegistroContenidoReferencia=e.idRegistroEvento 
			AND e.situacion IN(0,1,2,4,5) and e.tipoAudiencia in(12,60,141) ORDER BY e.fechaEvento DESC,e.horaInicioEvento DESC";
	
	$idAudienciaSobreseimiento=$con->obtenerValor($consulta);
	
	$consulta=" SELECT * FROM (

SELECT id__421_tablaDinamica,CONCAT(
 IF((SELECT nombre FROM 800_usuarios WHERE idUsuario=usuarioAsignado) IS NULL,'(NO asignado)',
 (SELECT nombre FROM 800_usuarios WHERE idUsuario=usuarioAsignado) ),' 
 (',(SELECT nombrePuesto FROM _416_tablaDinamica WHERE id__416_tablaDinamica=puestoOrganozacional),')')  AS usuario
 FROM _421_tablaDinamica WHERE idReferencia=".$idPerfil." AND usuarioAsignado<>-1 AND usuarioAsignado IS NOT NULL) AS tmp ORDER BY usuario ";

	$arrFirmantesUnidad=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT claveElemento,nombreElemento FROM 1018_catalogoVarios WHERE tipoElemento=36 ORDER BY nombreElemento";
	$arrParentezco=$con->obtenerFilasArreglo($consulta);	
	
	$consulta="SELECT id__379_tablaDinamica,lengua FROM _379_tablaDinamica ORDER BY lengua";
	$arrLengua=	$con->obtenerFilasArreglo($consulta);	
	
	
	$consulta="SELECT valor,texto FROM 1004_siNo";
	$arrSiNo=$con->obtenerFilasArreglo($consulta);
?>

var objGlobalInfoDocumento=null;
var judNotificadores=<?php echo $judNotificadores?>;
var arrSiNo=<?php echo $arrSiNo?>;
var arrFirmantesUnidad=<?php echo $arrFirmantesUnidad?>;
var arrJueces=<?php echo $arrJueces?>;
var idAudienciaSobreseimiento='<?php echo $idAudienciaSobreseimiento?>';
var arrMedidasCautelaresAdolescentes=<?php echo $arrMedidasCautelaresAdolescentes?>;
var arrMedidasCautelaresAdolescentesUGA=<?php echo $arrMedidasCautelaresAdolescentesUGA?>;
var arrMedidasCautelaresAdolescentesOTRO=<?php echo $arrMedidasCautelaresAdolescentesUGA?>;
var arrMedidasCautelaresAdultoOTRO=<?php echo $arrMedidasCautelaresAdultos?>;

var arrCondicionesSCAdolescentes=<?php echo $arrCondicionesSCAdolescentes?>;
var arrCondicionesSCAdolescentesUGA=<?php echo $arrCondicionesSCAdolescentesUGA?>;
var arrCondicionesSCAdolescentesOTRO=<?php echo $arrCondicionesSCAdultosUGA?>;
var arrCondicionesSCAdultosOTRO=<?php echo $arrCondicionesSCAdultosUGA?>;

var arrMedidasCautelaresAdultos=<?php echo $arrMedidasCautelaresAdultos?>;
var arrCondicionesSCAdultos=<?php echo $arrCondicionesSCAdultos?>;
var arrImputados=<?php echo $arrImputados?>;
var arrMostrarVictima=[['1','Nombre completo'],['2','Identidad reservada']];
var arrParentezco=<?php echo $arrParentezco?>;
var arrAudienciasCarpeta=<?php echo $arrAudiencias?>;
var idCarpeta='<?php echo $idCarpeta?>';
var carpetaAdministrativa='<?php echo $carpetaAdministrativa?>';
var arrFirmantes=<?php echo $arrFirmantes?>;
var arrLengua=<?php echo $arrLengua ?>;
Ext.onReady(inicializar);

function inicializar()
{
	arrCondicionesSCAdolescentesOTRO.splice(arrCondicionesSCAdolescentesOTRO.length,0,['0','Otro']);
    arrCondicionesSCAdultosOTRO.splice(arrCondicionesSCAdultosOTRO.length,0,['0','Otro','Otro']);
    arrMedidasCautelaresAdolescentesOTRO.splice(arrMedidasCautelaresAdolescentesOTRO.length,0,['0','Otro']);
    arrMedidasCautelaresAdultos.splice(arrMedidasCautelaresAdultos.length,0,['0','Otro']);
    arrMedidasCautelaresAdultoOTRO.splice(arrMedidasCautelaresAdultos.length,0,['0','Otro','Otro']);
    arrCondicionesSCAdultos.splice(arrCondicionesSCAdultos.length,0,['0','Otro']);
    

    arrMedidasCautelaresAdolescentes.splice(arrMedidasCautelaresAdolescentes.length,0,['0','Otro']);
    arrCondicionesSCAdolescentes.splice(arrCondicionesSCAdolescentes.length,0,['0','Otro']);
}

function  mostrarInterfaceParametrosSobreseimineto(cadObj,ventana)
{
	objGlobalInfoDocumento=eval('['+decodeURIComponent(cadObj)+']')[0];

	if(ventana)
		ventana.close();
	var cmbAudienciaSobreseimiento=crearComboExt('cmbAudienciaSobreseimiento',arrAudienciasCarpeta,335,95,400);
    var cmbAudienciaMedidasCautelares=crearComboExt('cmbAudienciaMedidasCautelares',arrAudienciasCarpeta,335,125,400);
    var cmbMostrarVictima=crearComboExt('cmbMostrarVictima',arrMostrarVictima,180,185,400);
    cmbMostrarVictima.setValue('1');
    var cmbImputados=crearComboExt('cmbImputados',arrImputados,160,65,300,{multiSelect:true});
	if(cmbImputados.getStore().getCount()==1)
    {
    	var x=0;
    	cmbImputados.setValue(cmbImputados.getStore().getAt(x).data.id);
    }
    
    
    var cmbFirmante=crearComboExt('cmbFirmante',arrFirmantes,180,215,400);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'<b>No de oficio a asignar:</b>'
                                                        },
                                                        {
                                                        	x:160,
                                                            y:5,
                                                            xtype:'numberfield',
                                                            id:'txtNoOficioAsignar',
                                                            allowDecimals:false,
                                                            allowNegative:false,
                                                            width:100
                                                        },
                                            			{
                                                        	x:10,
                                                            y:40,
                                                            html:'<b>Carpeta Judicial:</b>'
                                                        },
                                                        {
                                                        	x:160,
                                                            y:40,
                                                            html:'<span style="color: #900"><b>'+carpetaAdministrativa+'</b></span>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'<b>Imputados:</b>'
                                                        },
                                                        cmbImputados,
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            html:'<b>Audiencia en la cual se determina el sobreseimiento:</b>'
                                                        },
                                                        cmbAudienciaSobreseimiento,
                                                         {
                                                        	x:10,
                                                            y:130,
                                                            html:'<b>Audiencia en la cual se fijan las medidas cautelares:</b>'
                                                        },
                                                        cmbAudienciaMedidasCautelares,
                                                        {
                                                        	x:10,
                                                            y:160,
                                                            html:'<b>No de oficio en la cual se inform&oacute; de medidas cautelares:</b>'
                                                        },
                                                        {
                                                        	x:345,
                                                            y:155,
                                                            xtype:'numberfield',
                                                            id:'txtNoOficio',
                                                            allowDecimals:false,
                                                            allowNegative:false,
                                                            width:100
                                                        },
                                                        {
                                                        	x:10,
                                                            y:190,
                                                            html:'<b>Mostrar v&iacute;ctimas como:</b>'
                                                        },
                                                        cmbMostrarVictima,
                                                        {
                                                        	x:10,
                                                            y:220,
                                                            html:'<b>Firmado por:</b>'
                                                        },
                                                        cmbFirmante
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Se informa sobreseimiento',
										width: 810,
										height:360,
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
                                                                	gEx('txtNoOficioAsignar').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var txtNoOficioAsignar=gEx('txtNoOficioAsignar');
                                                                        var txtNoOficio=gEx('txtNoOficio');
                                                                        var imputados=cmbImputados.getValue();
                                                                        
                                                                        if(txtNoOficioAsignar.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	txtNoOficioAsignar.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el folio del oficio a asignar',resp1);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(imputados=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbImputados.focus();
                                                                            }
                                                                        	msgBox('Debe indicar almenos un imputado involucrado en el asunto',resp2);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(cmbAudienciaSobreseimiento.getValue()=='')
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	cmbAudienciaSobreseimiento.focus();
                                                                            }
                                                                        	msgBox('Debe indicar la audiencia en la cual se determina el sobreseimiento',resp3);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(cmbAudienciaMedidasCautelares.getValue()=='')
                                                                        {
                                                                        	function resp4()
                                                                            {
                                                                            	cmbAudienciaMedidasCautelares.focus();
                                                                            }
                                                                        	msgBox('Debe indicar la audiencia en la cual se fijan las medidas cautelares',resp4);
                                                                        	return;
                                                                        }
                                                                        
                                                                        
                                                                        if(txtNoOficio.getValue()=='')
                                                                        {
                                                                        	function resp5()
                                                                            {
                                                                            	txtNoOficio.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el folio del oficio en el cual se notific&oacute; las medidas cautelares',resp5);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(cmbFirmante.getValue()=='')
                                                                        {
                                                                        	function resp6()
                                                                            {
                                                                            	cmbFirmante.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el nombre del firmante del oficio',resp6);
                                                                        	return;
                                                                        }

                                                                        var cadParametros='{"noOficioAsignar":"'+txtNoOficioAsignar.getValue()+'","carpetaJudicial":"'+
                                                                        					carpetaAdministrativa+'","idCarpeta":"'+idCarpeta+'","imputados":"'+imputados+
                                                                                            '","audienciaSobreseimiento":"'+cmbAudienciaSobreseimiento.getValue()+
                                                                                            '","audienciaMedidaCautelar":"'+cmbAudienciaMedidasCautelares.getValue()+
                                                                                            '","noOficioMedidaCautelar":"'+txtNoOficio.getValue()+'","mostrarVictimasComo":"'+
                                                                                            cmbMostrarVictima.getValue()+'","firmante":"'+cmbFirmante.getValue()+'"}';
                                                                        
																	
                                                                    	guardarDatosDocumento(cadObj,cadParametros,ventanaAM);
                                                                    
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

function  mostrarInterfaceParametrosSolucionAlterna(cadObj,ventana)
{
	objGlobalInfoDocumento=eval('['+decodeURIComponent(cadObj)+']')[0];

	if(ventana)
		ventana.close();
	var cmbAudienciaCelebrar=crearComboExt('cmbAudienciaCelebrar',arrAudienciasCarpeta,160,95,400);
    var cmbMostrarVictima=crearComboExt('cmbMostrarVictima',arrMostrarVictima,180,125,400);
    cmbMostrarVictima.setValue('1');
    var cmbImputados=crearComboExt('cmbImputados',arrImputados,160,65,300,{multiSelect:true});
	if(cmbImputados.getStore().getCount()==1)
    {
    	var x=0;
    	cmbImputados.setValue(cmbImputados.getStore().getAt(x).data.id);
    }
    
    
    var cmbFirmante=crearComboExt('cmbFirmante',arrFirmantes,180,155,400);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'<b>No de oficio a asignar:</b>'
                                                        },
                                                        {
                                                        	x:160,
                                                            y:5,
                                                            xtype:'numberfield',
                                                            id:'txtNoOficioAsignar',
                                                            allowDecimals:false,
                                                            allowNegative:false,
                                                            width:100
                                                        },
                                            			{
                                                        	x:10,
                                                            y:40,
                                                            html:'<b>Carpeta Judicial:</b>'
                                                        },
                                                        {
                                                        	x:160,
                                                            y:40,
                                                            html:'<span style="color: #900"><b>'+carpetaAdministrativa+'</b></span>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'<b>Imputados:</b>'
                                                        },
                                                        cmbImputados,
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            html:'<b>Audiencia a celebrar:</b>'
                                                        },
                                                        cmbAudienciaCelebrar,
                                                        
                                                        {
                                                        	x:10,
                                                            y:130,
                                                            html:'<b>Mostrar v&iacute;ctimas como:</b>'
                                                        },
                                                        cmbMostrarVictima,
                                                        {
                                                        	x:10,
                                                            y:160,
                                                            html:'<b>Firmado por:</b>'
                                                        },
                                                        cmbFirmante
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Se informa sobreseimiento',
										width: 700,
										height:300,
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
                                                                	gEx('txtNoOficioAsignar').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var txtNoOficioAsignar=gEx('txtNoOficioAsignar');
                                                                        var imputados=cmbImputados.getValue();
                                                                        
                                                                        if(txtNoOficioAsignar.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	txtNoOficioAsignar.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el folio del oficio a asignar',resp1);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(imputados=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbImputados.focus();
                                                                            }
                                                                        	msgBox('Debe indicar almenos un imputado involucrado en el asunto',resp2);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(cmbAudienciaCelebrar.getValue()=='')
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	cmbAudienciaCelebrar.focus();
                                                                            }
                                                                        	msgBox('Debe indicar la audiencia a celebrar',resp3);
                                                                        	return;
                                                                        }
                                                                        
                                                                        
                                                                        
                                                                        if(cmbFirmante.getValue()=='')
                                                                        {
                                                                        	function resp6()
                                                                            {
                                                                            	cmbFirmante.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el nombre del firmante del oficio',resp6);
                                                                        	return;
                                                                        }

                                                                        var cadParametros='{"noOficioAsignar":"'+txtNoOficioAsignar.getValue()+'","carpetaJudicial":"'+
                                                                        					carpetaAdministrativa+'","idCarpeta":"'+idCarpeta+'","imputados":"'+imputados+
                                                                                            '","audienciaCelebrar":"'+cmbAudienciaCelebrar.getValue()+
                                                                                            '","mostrarVictimasComo":"'+
                                                                                            cmbMostrarVictima.getValue()+'","firmante":"'+cmbFirmante.getValue()+'"}';
                                                                        
																	
                                                                    	guardarDatosDocumento(cadObj,cadParametros,ventanaAM);
                                                                    
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

function  mostrarInterfaceParametrosMedidaCautelar(cadObj,ventana)
{

	objGlobalInfoDocumento=eval('['+decodeURIComponent(cadObj)+']')[0];

	if(ventana)
		ventana.close();
    var cmbAudienciaCelebrar=crearComboExt('cmbAudienciaCelebrar',arrAudienciasCarpeta,300,95,400);
	var cmbMostrarVictima=crearComboExt('cmbMostrarVictima',arrMostrarVictima,180,125,400);
    cmbMostrarVictima.setValue('1');
    var cmbImputados=crearComboExt('cmbImputados',arrImputados,160,65,300);
	
    
    cmbImputados.on('select',function(cmb,registro)
    						{
                            	function funcAjax()
                                {
                                    var resp=peticion_http.responseText;
                                    arrResp=resp.split('|');
                                    if(arrResp[0]=='1')
                                    {
                                        //var arrMedidas=eval(arrResp[1]);
                                        //gEx('gMedidas').getStore().loadData(arrMedidas);
                                    }
                                    else
                                    {
                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                    }
                                }
                                obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=221&c='+carpetaAdministrativa+'&iC='+idCarpeta+'&i='+registro.data.id,true);
                            }
    				)
    
    
    
    var cmbFirmante=crearComboExt('cmbFirmante',arrFirmantes,180,155,400);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            
                                            			{
                                                        	xtype:'tabpanel',
                                                            region:'center',
                                                            id:'tabRegistros',
                                                            activeTab:0,
                                                            items:	[
                                                            				{
                                                                                 xtype:'panel',
                                                                                  layout:'absolute',
                                                                                  defaultType: 'label',
                                                                                  title:'Datos Generales',
                                                                                  items:	[
                                                                                                {
                                                                                                    x:10,
                                                                                                    y:10,
                                                                                                    html:'<b>No de oficio a asignar:</b>'
                                                                                                },
                                                                                                {
                                                                                                    x:160,
                                                                                                    y:5,
                                                                                                    xtype:'numberfield',
                                                                                                    id:'txtNoOficioAsignar',
                                                                                                    allowDecimals:false,
                                                                                                    allowNegative:false,
                                                                                                    width:100
                                                                                                },
                                                                                                {
                                                                                                    x:10,
                                                                                                    y:40,
                                                                                                    html:'<b>Carpeta Judicial:</b>'
                                                                                                },
                                                                                                {
                                                                                                    x:160,
                                                                                                    y:40,
                                                                                                    html:'<span style="color: #900"><b>'+carpetaAdministrativa+'</b></span>'
                                                                                                },
                                                                                                {
                                                                                                    x:10,
                                                                                                    y:70,
                                                                                                    html:'<b>Imputados:</b>'
                                                                                                },
                                                                                                cmbImputados,
                                                                                                {
                                                                                                    x:10,
                                                                                                    y:100,
                                                                                                    html:'<b>Audiencia imposici&oacute;n de medidas cautelares:</b>'
                                                                                                },
                                                                                                cmbAudienciaCelebrar,
                                                                                                {
                                                                                                    x:10,
                                                                                                    y:130,
                                                                                                    html:'<b>Mostrar v&iacute;ctimas como:</b>'
                                                                                                },
                                                                                                cmbMostrarVictima,
                                                                                                {
                                                                                                    x:10,
                                                                                                    y:160,
                                                                                                    html:'<b>Firmado por:</b>'
                                                                                                },
                                                                                                cmbFirmante  
                                                                                        
                                                                                            ]
                                                                          },
                                                                          
                                                                          {
                                                                              xtype:'panel',
                                                                              layout:'absolute',
                                                                              defaultType: 'label',
                                                                              title:'Medidas Cautelares',
                                                                              items:	[
                                                                                          {
                                                                                              x:10,
                                                                                              y:10,
                                                                                              html:'Seleccione las condiciones de suspenci&oacute;n condicional de proceso que apliquen:'
                                                                                          },
                                                                                          crearGridRegistrosMCAdultos()
                                                                                          
                                                                                          
                                                                                      ]
                                                                          }
                                                            		]
                                                        }
                                            			
                                            			
                                            			
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Se informa imposición de medida cautelar',
										width: 750,
										height:480,
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
                                                                	gEx('txtNoOficioAsignar').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var txtNoOficioAsignar=gEx('txtNoOficioAsignar');
                                                                        var imputados=cmbImputados.getValue();
                                                                        
                                                                        if(txtNoOficioAsignar.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	gEx('tabRegistros').setActiveTab(0);
                                                                            	txtNoOficioAsignar.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el folio del oficio a asignar',resp1);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(imputados=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	gEx('tabRegistros').setActiveTab(0);
                                                                            	cmbImputados.focus();
                                                                            }
                                                                        	msgBox('Debe indicar almenos un imputado involucrado en el asunto',resp2);
                                                                        	return;
                                                                        }
                                                                        
                                                                        
                                                                        if(cmbAudienciaCelebrar.getValue()=='')
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	gEx('tabRegistros').setActiveTab(0);
                                                                            	cmbAudienciaCelebrar.focus();
                                                                            }
                                                                        	msgBox('Debe indicar la audiencia en la cual se imponen las medidasa cautelares',resp3);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(cmbFirmante.getValue()=='')
                                                                        {
                                                                        	function resp6()
                                                                            {
                                                                            	gEx('tabRegistros').setActiveTab(0);
                                                                            	cmbFirmante.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el nombre del firmante del oficio',resp6);
                                                                        	return;
                                                                        }
                                                                        
                                                                        var listaMedidas='';
                                                                        
                                                                        var x;
                                                                        var fila;
                                                                        var o;
                                                                        for(x=0;x<gEx('gMedidaCautelar').getStore().getCount();x++)
                                                                        {
                                                                        	fila=gEx('gMedidaCautelar').getStore().getAt(x);
                                                                            o='{"idMedidaCautelar":"'+fila.data.idMedidaCautelar+'","detalles":"'+cv(fila.data.detallesAdicionales)+'"}';
                                                                            if(listaMedidas=='')
                                                                            	listaMedidas=o;
                                                                            else
                                                                            	listaMedidas+=','+o
                                                                        }
                                                                        
                                                                        
                                                                        if(listaMedidas=='')
                                                                        {
                                                                        	
                                                                        	function resp12()
                                                                            {
                                                                            	gEx('tabRegistros').setActiveTab(1);
                                                                            	
                                                                            }
                                                                        	msgBox('Debe indicar las medidas cautelares a informar',resp12);
                                                                        	return
                                                                        }


                                                                        var cadParametros='{"noOficioAsignar":"'+txtNoOficioAsignar.getValue()+'","carpetaJudicial":"'+
                                                                        					carpetaAdministrativa+'","idCarpeta":"'+idCarpeta+'","imputados":"'+imputados+
                                                                                            '","mostrarVictimasComo":"'+cmbMostrarVictima.getValue()+'","firmante":"'+
                                                                                            cmbFirmante.getValue()+'","medidadCautelares":['+listaMedidas+
                                                                                            '],"audienciaMedidas":"'+cmbAudienciaCelebrar.getValue()+'"}';
                                                                        
																	
                                                                    	guardarDatosDocumento(cadObj,cadParametros,ventanaAM);
                                                                    
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
    if(cmbImputados.getStore().getCount()==1)
    {
    	var x=0;
    	cmbImputados.setValue(cmbImputados.getStore().getAt(x).data.id);
        dispararEventoSelectCombo('cmbImputados');
    }
}


function  mostrarInterfaceParametrosRespuestaAdolescentes(cadObj,ventana)
{
	objGlobalInfoDocumento=eval('['+decodeURIComponent(cadObj)+']')[0];

	if(ventana)
		ventana.close();
	
    var cmbImputados=crearComboExt('cmbImputados',arrImputados,160,65,400,{multiSelect:false});
	if(cmbImputados.getStore().getCount()==1)
    {
    	var x=0;
    	cmbImputados.setValue(cmbImputados.getStore().getAt(x).data.id);
    }
    
    var cmbExisteMedidaCautelar=crearComboExt('cmbExisteMedidaCautelar',arrSiNo,210,265,120);
    cmbExisteMedidaCautelar.on('select',function(cmb,registro)
    									{
                                        	switch(registro.data.id)
                                            {
                                            	case '1':
                                                	gEx('gRegistrosMedidaCautelar').enable();
                                                break;
                                                case '0':
                                                	gEx('gRegistrosMedidaCautelar').getStore().removeAll();
                                                	gEx('gRegistrosMedidaCautelar').disable();
                                                break;
                                            }
                                        }
    							)
    var cmbExisteCondicionSC=crearComboExt('cmbExisteCondicionSC',arrSiNo,310,295,120);
   	cmbExisteCondicionSC.on('select',function(cmb,registro)
    									{
                                        	switch(registro.data.id)
                                            {
                                            	case '1':
                                                	gEx('gRegistrosCondicionSuspension').enable();
                                                break;
                                                case '0':
                                                	gEx('gRegistrosCondicionSuspension').getStore().removeAll();
                                                	gEx('gRegistrosCondicionSuspension').disable();
                                                break;
                                            }
                                        }
    							)
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	xtype:'tabpanel',
                                                            region:'center',
                                                            id:'tabRegistros',
                                                            activeTab:0,
                                                            items:	[
                                                            			{
                                                                        	xtype:'panel',
                                                                            layout:'absolute',
                                                                            defaultType: 'label',
                                                                            title:'Datos Generales',
                                                                            items:	[
                                                                            			{
                                                                                            x:10,
                                                                                            y:10,
                                                                                            html:'<b>No de oficio a asignar:</b>'
                                                                                        },
                                                                                        {
                                                                                            x:160,
                                                                                            y:5,
                                                                                            xtype:'numberfield',
                                                                                            id:'txtNoOficioAsignar',
                                                                                            allowDecimals:false,
                                                                                            allowNegative:false,
                                                                                            width:100
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:40,
                                                                                            html:'<b>Carpeta Judicial:</b>'
                                                                                        },
                                                                                        {
                                                                                            x:160,
                                                                                            y:40,
                                                                                            html:'<span style="color: #900"><b>'+carpetaAdministrativa+'</b></span>'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:70,
                                                                                            html:'<b>Imputado:</b>'
                                                                                        },
                                                                                        cmbImputados,
                                                                                        
                                                                                        {
                                                                                            x:10,
                                                                                            y:100,
                                                                                            html:'<b>No de oficio que se responde:</b>'
                                                                                        },
                                                                                        
                                                                                        {
                                                                                            x:210,
                                                                                            y:95,
                                                                                            xtype:'textfield',
                                                                                            id:'txtNoOficio',
                                                                                            width:200
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:130,
                                                                                            html:'<b>Fecha del oficio que responde:</b>'
                                                                                        },
                                                                                        
                                                                                        {
                                                                                            x:210,
                                                                                            y:125,
                                                                                            xtype:'datefield',
                                                                                            id:'fechaOficio'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:160,
                                                                                            html:'<b>Fecha de viculaci&oacute;n a proceso:</b>'
                                                                                        },
                                                                                        
                                                                                        {
                                                                                            x:210,
                                                                                            y:155,
                                                                                            xtype:'datefield',
                                                                                            id:'fechaVinculacion'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:190,
                                                                                            html:'<b>Nombre destinatario:</b>'
                                                                                        },
                                                                                        {
                                                                                            x:210,
                                                                                            y:185,
                                                                                            width:350,
                                                                                            xtype:'textfield',
                                                                                            id:'nombreDestinatario'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:220,
                                                                                            html:'<b>Puesto destinatario:</b>'
                                                                                        },
                                                                                        {
                                                                                            x:210,
                                                                                            y:215,
                                                                                            width:450,
                                                                                            xtype:'textarea',
                                                                                            height:40,
                                                                                            id:'puestoDestinatario'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:270,
                                                                                            html:'<b>Existe alguna medida cautelar:</b>'
                                                                                        },
                                                                                        cmbExisteMedidaCautelar,
                                                                                        {
                                                                                            x:10,
                                                                                            y:300,
                                                                                            html:'<b>Existe alguna condici&oacute;n de suspensi&oacute;n condicional:</b>'
                                                                                        },
                                                                                        cmbExisteCondicionSC
                                                                            		]
                                                                        },
                                                                        {
                                                                        	xtype:'panel',
                                                                            layout:'absolute',
                                                                            defaultType: 'label',
                                                                            title:'Medidas Cautelares',
                                                                            items:	[
                                                                            			{
                                                                                        	x:10,
                                                                                            y:10,
                                                                                            html:'Seleccione las medidas cautelares que apliquen:'
                                                                                        },
                                                                                        crearGridRegistrosCarpetasJudiciales('2','1','gRegistrosMedidaCautelar')
                                                                                        
                                                                                        
                                                                            		]
                                                                        },
                                                                        {
                                                                        	xtype:'panel',
                                                                            layout:'absolute',
                                                                            defaultType: 'label',
                                                                            title:'Condiciones de suspenci&oacute;n condicional de proceso',
                                                                            items:	[
                                                                            			{
                                                                                        	x:10,
                                                                                            y:10,
                                                                                            html:'Seleccione las condiciones de suspenci&oacute;n condicional de proceso que apliquen:'
                                                                                        },
                                                                                        crearGridRegistrosCarpetasJudiciales('2','2','gRegistrosCondicionSuspension')
                                                                                        
                                                                                        
                                                                            		]
                                                                        }
                                                            		]
                                                        }
                                            			
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: objGlobalInfoDocumento.tituloDocumento,
										width: 810,
										height:440,
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
                                                                	gEx('txtNoOficioAsignar').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var txtNoOficioAsignar=gEx('txtNoOficioAsignar');
                                                                        var txtNoOficio=gEx('txtNoOficio');
                                                                        var imputados=cmbImputados.getValue();
                                                                        var txtNoOficio=gEx('txtNoOficio');
                                                                        var fechaOficio=gEx('fechaOficio');
                                                                        var fechaVinculacion=gEx('fechaVinculacion');
                                                                      	var nombreDestinatario=gEx('nombreDestinatario');
                                                                        var puestoDestinatario=gEx('puestoDestinatario');
                                                                        /*if(txtNoOficioAsignar.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	txtNoOficioAsignar.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el folio del oficio a asignar',resp1);
                                                                        	return;
                                                                        }*/
                                                                        
                                                                        if(imputados=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbImputados.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el imputado involucrado en el asunto',resp2);
                                                                        	return;
                                                                        }
                                                                        
                                                                        
                                                                        if(txtNoOficio.getValue()=='')
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	txtNoOficio.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el n&uacute;mero del oficio que responde',resp3);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(fechaOficio.getValue()=='')
                                                                        {
                                                                        	function resp4()
                                                                            {
                                                                            	fechaOficio.focus();
                                                                            }
                                                                        	msgBox('Debe indicar la fecha del oficio que responde',resp4);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(fechaVinculacion.getValue()=='')
                                                                        {
                                                                        	function resp5()
                                                                            {
                                                                            	fechaVinculacion.focus();
                                                                            }
                                                                        	msgBox('Debe indicar la fecha de vinculaci&oacute;n a proceso',resp5);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(nombreDestinatario.getValue()=='')
                                                                        {
                                                                        	function resp6()
                                                                            {
                                                                            	nombreDestinatario.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el nombre del destinatario del oficio',resp6);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(puestoDestinatario.getValue()=='')
                                                                        {
                                                                        	function resp7()
                                                                            {
                                                                            	puestoDestinatario.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el puesto del destinatario del oficio',resp7);
                                                                        	return;
                                                                        }
                                                                        
                                                                        
                                                                        if(cmbExisteMedidaCautelar.getValue()=='')
                                                                        {
                                                                        	function resp8()
                                                                            {
                                                                            	cmbExisteMedidaCautelar.focus();
                                                                            }
                                                                        	msgBox('Debe indicar si existe alguna medida cautelar impuesta al imputado',resp8);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(cmbExisteCondicionSC.getValue()=='')
                                                                        {
                                                                        	function resp9()
                                                                            {
                                                                            	cmbExisteCondicionSC.focus();
                                                                            }
                                                                        	msgBox('Debe indicar si existe alguna condici&oacute;n de suspensi&oacute;n condicional impuesta al imputado',resp9);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if((cmbExisteMedidaCautelar.getValue()=='1')&&(gEx('gRegistrosMedidaCautelar').getStore().getCount()==0))
                                                                        {
                                                                        	
                                                                        	function resp10()
                                                                            {
                                                                            	gEx('tabRegistros').setActiveTab(1);
                                                                            }
                                                                        	msgBox('Debe indicar las medidas cautelares impuestas al imputado',resp10);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if((cmbExisteCondicionSC.getValue()=='1')&&(gEx('gRegistrosCondicionSuspension').getStore().getCount()==0))
                                                                        {
                                                                        	
                                                                        	function resp11()
                                                                            {
                                                                            	gEx('tabRegistros').setActiveTab(2);
                                                                            }
                                                                        	msgBox('Debe indicar las condiciones de suspensi&oacute;n condicional impuestas al imputado',resp11);
                                                                        	return;
                                                                        }
                                                                        var o='';
                                                                        var listaMedidasCautelares='';
                                                                        var listaCondiciones='';
                                                                        var fila;
                                                                        var x;
                                                                        
                                                                        for(x=0;x<gEx('gRegistrosMedidaCautelar').getStore().getCount();x++)
                                                                        {
                                                                        	fila=gEx('gRegistrosMedidaCautelar').getStore().getAt(x);
                                                                            o='{"carpetaAdministrativa":"'+fila.data.carpetaAdministrativa+'","fracciones":'+fila.data.fracciones+'}';
                                                                            if(listaMedidasCautelares=='')
                                                                            	listaMedidasCautelares=o;
                                                                            else
                                                                            	listaMedidasCautelares+=','+o;
                                                                            
                                                                        }
                                                                        
                                                                        
                                                                        for(x=0;x<gEx('gRegistrosCondicionSuspension').getStore().getCount();x++)
                                                                        {
                                                                        	fila=gEx('gRegistrosCondicionSuspension').getStore().getAt(x);
                                                                            o='{"carpetaAdministrativa":"'+fila.data.carpetaAdministrativa+'","fracciones":'+fila.data.fracciones+'}';
                                                                            if(listaCondiciones=='')
                                                                            	listaCondiciones=o;
                                                                            else
                                                                            	listaCondiciones+=','+o;
                                                                        }
                                                                        
                                                                       
	
                                                                        var cadParametros='{"noOficioAsignar":"'+txtNoOficioAsignar.getValue()+'","carpetaJudicial":"'+
                                                                        					carpetaAdministrativa+'","idCarpeta":"'+idCarpeta+'","imputados":"'+imputados+
                                                                                            '","oficioResponde":"'+cv(txtNoOficio.getValue())+'","fechaOficioResponde":"'+
                                                                                            fechaOficio.getValue().format('Y-m-d')+'","fechaVinculacionProceso":"'+
                                                                                            fechaVinculacion.getValue().format('Y-m-d')+'","nombreDestinatario":"'+
                                                                                            cv(nombreDestinatario.getValue())+'","puestoDestinatario":"'+cv(puestoDestinatario.getValue())+
                                                                                            '","existeMedidaCautelar":"'+cmbExisteMedidaCautelar.getValue()+'",'+
                                                                                            '"existeSuspencionCP":"'+cmbExisteCondicionSC.getValue()+
                                                                                            '","medidasCautelares":['+listaMedidasCautelares+'],"suspencionesCondicional":['+
                                                                                            listaCondiciones+']}';
                                                                        
                                                                    	guardarDatosDocumento(cadObj,cadParametros,ventanaAM);
                                                                    
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
                                
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var objInfo=eval(arrResp[1])[0];
            cmbImputados.setValue(objInfo.imputado);
            gEx('txtNoOficio').setValue(objInfo.noOficioResponde);
            gEx('fechaOficio').setValue(objInfo.fechaOficio);
            gEx('fechaVinculacion').setValue(objInfo.fechaVinculacionProceso);
            gEx('nombreDestinatario').setValue(objInfo.nombreDestinatario);
            gEx('puestoDestinatario').setValue(objInfo.puestoDestinatario);
            ventanaAM.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_MedidasCautelares.php',funcAjax, 'POST','funcion=1&iR='+gE('iRegistroMedidaCautelar').value,true);                          
	
	

}

function  mostrarInterfaceParametrosRespuestaAdultos(cadObj,ventana)
{
	objGlobalInfoDocumento=eval('['+decodeURIComponent(cadObj)+']')[0];

	if(ventana)
		ventana.close();
	
    var cmbImputados=crearComboExt('cmbImputados',arrImputados,160,65,400,{multiSelect:false});
	if(cmbImputados.getStore().getCount()==1)
    {
    	var x=0;
    	cmbImputados.setValue(cmbImputados.getStore().getAt(x).data.id);
    }
    
    var cmbExisteMedidaCautelar=crearComboExt('cmbExisteMedidaCautelar',arrSiNo,310,265,120);
    cmbExisteMedidaCautelar.on('select',function(cmb,registro)
    									{
                                        	switch(registro.data.id)
                                            {
                                            	case '1':
                                                	gEx('gRegistrosMedidaCautelar').enable();
                                                break;
                                                case '0':
                                                	gEx('gRegistrosMedidaCautelar').getStore().removeAll();
                                                	gEx('gRegistrosMedidaCautelar').disable();
                                                break;
                                            }
                                        }
    							)
    var cmbExisteCondicionSC=crearComboExt('cmbExisteCondicionSC',arrSiNo,310,295,120);
   	cmbExisteCondicionSC.on('select',function(cmb,registro)
    									{
                                        	switch(registro.data.id)
                                            {
                                            	case '1':
                                                	gEx('gRegistrosCondicionSuspension').enable();
                                                break;
                                                case '0':
                                                	gEx('gRegistrosCondicionSuspension').getStore().removeAll();
                                                	gEx('gRegistrosCondicionSuspension').disable();
                                                break;
                                            }
                                        }
    							)
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	xtype:'tabpanel',
                                                            region:'center',
                                                            id:'tabRegistros',
                                                            activeTab:0,
                                                            items:	[
                                                            			{
                                                                        	xtype:'panel',
                                                                            layout:'absolute',
                                                                            defaultType: 'label',
                                                                            title:'Datos Generales',
                                                                            items:	[
                                                                            			{
                                                                                            x:10,
                                                                                            y:10,
                                                                                            html:'<b>No de oficio a asignar:</b>'
                                                                                        },
                                                                                        {
                                                                                            x:160,
                                                                                            y:5,
                                                                                            xtype:'numberfield',
                                                                                            id:'txtNoOficioAsignar',
                                                                                            allowDecimals:false,
                                                                                            allowNegative:false,
                                                                                            width:100
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:40,
                                                                                            html:'<b>Carpeta Judicial:</b>'
                                                                                        },
                                                                                        {
                                                                                            x:160,
                                                                                            y:40,
                                                                                            html:'<span style="color: #900"><b>'+carpetaAdministrativa+'</b></span>'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:70,
                                                                                            html:'<b>Imputado:</b>'
                                                                                        },
                                                                                        cmbImputados,
                                                                                        
                                                                                        {
                                                                                            x:10,
                                                                                            y:100,
                                                                                            html:'<b>No de oficio que se responde:</b>'
                                                                                        },
                                                                                        
                                                                                        {
                                                                                            x:210,
                                                                                            y:95,
                                                                                            xtype:'textfield',
                                                                                            id:'txtNoOficio',
                                                                                            width:200
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:130,
                                                                                            html:'<b>Fecha del oficio que responde:</b>'
                                                                                        },
                                                                                        
                                                                                        {
                                                                                            x:210,
                                                                                            y:125,
                                                                                            xtype:'datefield',
                                                                                            id:'fechaOficio'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:160,
                                                                                            html:'<b>Fecha de viculaci&oacute;n a proceso:</b>'
                                                                                        },
                                                                                        
                                                                                        {
                                                                                            x:210,
                                                                                            y:155,
                                                                                            xtype:'datefield',
                                                                                            id:'fechaVinculacion'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:190,
                                                                                            html:'<b>Nombre destinatario:</b>'
                                                                                        },
                                                                                        {
                                                                                            x:210,
                                                                                            y:185,
                                                                                            width:350,
                                                                                            xtype:'textfield',
                                                                                            id:'nombreDestinatario'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:220,
                                                                                            html:'<b>Puesto destinatario:</b>'
                                                                                        },
                                                                                        {
                                                                                            x:210,
                                                                                            y:215,
                                                                                            width:450,
                                                                                            xtype:'textarea',
                                                                                            height:40,
                                                                                            id:'puestoDestinatario'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:270,
                                                                                            html:'<b>Existe alguna medida cautelar:</b>'
                                                                                        },
                                                                                        cmbExisteMedidaCautelar,
                                                                                        {
                                                                                            x:10,
                                                                                            y:300,
                                                                                            html:'<b>Existe alguna condici&oacute;n de suspensi&oacute;n condicional:</b>'
                                                                                        },
                                                                                        cmbExisteCondicionSC
                                                                            		]
                                                                        },
                                                                        {
                                                                        	xtype:'panel',
                                                                            layout:'absolute',
                                                                            defaultType: 'label',
                                                                            title:'Medidas Cautelares',
                                                                            items:	[
                                                                            			{
                                                                                        	x:10,
                                                                                            y:10,
                                                                                            html:'Seleccione las medidas cautelares que apliquen:'
                                                                                        },
                                                                                        crearGridRegistrosCarpetasJudiciales('1','1','gRegistrosMedidaCautelar')
                                                                                        
                                                                                        
                                                                            		]
                                                                        },
                                                                        {
                                                                        	xtype:'panel',
                                                                            layout:'absolute',
                                                                            defaultType: 'label',
                                                                            title:'Condiciones de suspenci&oacute;n condicional de proceso',
                                                                            items:	[
                                                                            			{
                                                                                        	x:10,
                                                                                            y:10,
                                                                                            html:'Seleccione las condiciones de suspenci&oacute;n condicional de proceso que apliquen:'
                                                                                        },
                                                                                        crearGridRegistrosCarpetasJudiciales('1','2','gRegistrosCondicionSuspension')
                                                                                        
                                                                                        
                                                                            		]
                                                                        }
                                                            		]
                                                        }
                                            			
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Contestaci&oacute;n adultos',
										width: 810,
										height:440,
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
                                                                	gEx('txtNoOficioAsignar').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var txtNoOficioAsignar=gEx('txtNoOficioAsignar');
                                                                        var txtNoOficio=gEx('txtNoOficio');
                                                                        var imputados=cmbImputados.getValue();
                                                                        var txtNoOficio=gEx('txtNoOficio');
                                                                        var fechaOficio=gEx('fechaOficio');
                                                                        var fechaVinculacion=gEx('fechaVinculacion');
                                                                      	var nombreDestinatario=gEx('nombreDestinatario');
                                                                        var puestoDestinatario=gEx('puestoDestinatario');
                                                                        /*if(txtNoOficioAsignar.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	txtNoOficioAsignar.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el folio del oficio a asignar',resp1);
                                                                        	return;
                                                                        }*/
                                                                        
                                                                        if(imputados=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbImputados.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el imputado involucrado en el asunto',resp2);
                                                                        	return;
                                                                        }
                                                                        
                                                                        
                                                                        if(txtNoOficio.getValue()=='')
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	txtNoOficio.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el n&uacute;mero del oficio que responde',resp3);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(fechaOficio.getValue()=='')
                                                                        {
                                                                        	function resp4()
                                                                            {
                                                                            	fechaOficio.focus();
                                                                            }
                                                                        	msgBox('Debe indicar la fecha del oficio que responde',resp4);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(fechaVinculacion.getValue()=='')
                                                                        {
                                                                        	function resp5()
                                                                            {
                                                                            	fechaVinculacion.focus();
                                                                            }
                                                                        	msgBox('Debe indicar la fecha de vinculaci&oacute;n a proceso',resp5);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(nombreDestinatario.getValue()=='')
                                                                        {
                                                                        	function resp6()
                                                                            {
                                                                            	nombreDestinatario.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el nombre del destinatario del oficio',resp6);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(puestoDestinatario.getValue()=='')
                                                                        {
                                                                        	function resp7()
                                                                            {
                                                                            	puestoDestinatario.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el puesto del destinatario del oficio',resp7);
                                                                        	return;
                                                                        }
                                                                        
                                                                        
                                                                        if(cmbExisteMedidaCautelar.getValue()=='')
                                                                        {
                                                                        	function resp8()
                                                                            {
                                                                            	cmbExisteMedidaCautelar.focus();
                                                                            }
                                                                        	msgBox('Debe indicar si existe alguna medida cautelar impuesta al imputado',resp8);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(cmbExisteCondicionSC.getValue()=='')
                                                                        {
                                                                        	function resp9()
                                                                            {
                                                                            	cmbExisteCondicionSC.focus();
                                                                            }
                                                                        	msgBox('Debe indicar si existe alguna condici&oacute;n de suspensi&oacute;n condicional impuesta al imputado',resp9);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if((cmbExisteMedidaCautelar.getValue()=='1')&&(gEx('gRegistrosMedidaCautelar').getStore().getCount()==0))
                                                                        {
                                                                        	
                                                                        	function resp10()
                                                                            {
                                                                            	gEx('tabRegistros').setActiveTab(1);
                                                                            }
                                                                        	msgBox('Debe indicar las medidas cautelares impuestas al imputado',resp10);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if((cmbExisteCondicionSC.getValue()=='1')&&(gEx('gRegistrosCondicionSuspension').getStore().getCount()==0))
                                                                        {
                                                                        	
                                                                        	function resp11()
                                                                            {
                                                                            	gEx('tabRegistros').setActiveTab(2);
                                                                            }
                                                                        	msgBox('Debe indicar las condiciones de suspensi&oacute;n condicional impuestas al imputado',resp11);
                                                                        	return;
                                                                        }
                                                                        var o='';
                                                                        var listaMedidasCautelares='';
                                                                        var listaCondiciones='';
                                                                        var fila;
                                                                        var x;
                                                                        
                                                                        for(x=0;x<gEx('gRegistrosMedidaCautelar').getStore().getCount();x++)
                                                                        {
                                                                        	fila=gEx('gRegistrosMedidaCautelar').getStore().getAt(x);
                                                                            o='{"carpetaAdministrativa":"'+fila.data.carpetaAdministrativa+'","fracciones":'+fila.data.fracciones+'}';
                                                                            if(listaMedidasCautelares=='')
                                                                            	listaMedidasCautelares=o;
                                                                            else
                                                                            	listaMedidasCautelares+=','+o;
                                                                            
                                                                        }
                                                                        
                                                                        
                                                                        for(x=0;x<gEx('gRegistrosCondicionSuspension').getStore().getCount();x++)
                                                                        {
                                                                        	fila=gEx('gRegistrosCondicionSuspension').getStore().getAt(x);
                                                                            o='{"carpetaAdministrativa":"'+fila.data.carpetaAdministrativa+'","fracciones":'+fila.data.fracciones+'}';
                                                                            if(listaCondiciones=='')
                                                                            	listaCondiciones=o;
                                                                            else
                                                                            	listaCondiciones+=','+o;
                                                                            
                                                                        }
                                                                        
                                                                       
	
                                                                        var cadParametros='{"noOficioAsignar":"'+txtNoOficioAsignar.getValue()+'","carpetaJudicial":"'+
                                                                        					carpetaAdministrativa+'","idCarpeta":"'+idCarpeta+'","imputados":"'+imputados+
                                                                                            '","oficioResponde":"'+cv(txtNoOficio.getValue())+'","fechaOficioResponde":"'+
                                                                                            fechaOficio.getValue().format('Y-m-d')+'","fechaVinculacionProceso":"'+
                                                                                            fechaVinculacion.getValue().format('Y-m-d')+'","nombreDestinatario":"'+
                                                                                            cv(nombreDestinatario.getValue())+'","puestoDestinatario":"'+cv(puestoDestinatario.getValue())+
                                                                                            '","existeMedidaCautelar":"'+cmbExisteMedidaCautelar.getValue()+'",'+
                                                                                            '"existeSuspencionCP":"'+cmbExisteCondicionSC.getValue()+
                                                                                            '","medidasCautelares":['+listaMedidasCautelares+'],"suspencionesCondicional":['+
                                                                                            listaCondiciones+']}';
                                                                        
																	
                                                                    	guardarDatosDocumento(cadObj,cadParametros,ventanaAM);
                                                                    
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
                                
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var objInfo=eval(arrResp[1])[0];
            cmbImputados.setValue(objInfo.imputado);
            gEx('txtNoOficio').setValue(objInfo.noOficioResponde);
            gEx('fechaOficio').setValue(objInfo.fechaOficio);
            gEx('fechaVinculacion').setValue(objInfo.fechaVinculacionProceso);
            gEx('nombreDestinatario').setValue(objInfo.nombreDestinatario);
            gEx('puestoDestinatario').setValue(objInfo.puestoDestinatario);
            ventanaAM.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_MedidasCautelares.php',funcAjax, 'POST','funcion=1&iR='+gE('iRegistroMedidaCautelar').value,true);                          
	
	

}

function crearGridRegistros(arrDatos,idGrid)
{
	var dsDatos=arrDatos;
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idRegistro'},
                                                                    {name: 'leyenda'},
                                                                    {name: 'fraccion'},
                                                                    {name: 'detallesAdicionales'},
                                                                    {name: 'seleccionado'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	
	
    var checkColumn = new Ext.grid.CheckColumn	(
	 												{
													   header: '',
													   dataIndex: 'seleccionado',
													   width: 30
													}
												);
    
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	
														checkColumn,
														{
															header:'',
															width:350,
															sortable:true,
															dataIndex:'leyenda',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	meta.attr='style="height:auto; min-height:21px; white-space: normal;"';
                                                                    	return mostrarValorDescripcion(val);
                                                                    }
														},
                                                        {
															header:'Detalles adicionales',
															width:350,
															sortable:true,
															dataIndex:'detallesAdicionales',
                                                            editor:	{
                                                            			xtype:'textarea',
                                                                        height:40
                                                            		},
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	meta.attr='style="height:auto; min-height:21px; white-space: normal;"';
                                                                    	return mostrarValorDescripcion(escaparEnter(val));
                                                                    }
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:idGrid,
                                                            store:alDatos,
                                                            frame:false,
                                                            y:70,
                                                            x:10,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            clicksToEdit:1,
                                                            columnLines : true,
                                                            height:260,
                                                            width:750,
                                                            plugins:[checkColumn]
                                                        }
                                                    );

	tblGrid.on('beforeedit',function(e)
    						{
                            	if(e.field=='seleccionado')
                                {
                                	if(!e.value)
                                    {
                                    	
                                    }
                                    else
                                    {
                                    	e.record.set('detallesAdicionales','');
                                    }
                                }
                                else
                                {
                                	if(!e.record.data.seleccionado)
                                    {
                                    	e.cancel=true;
                                    }
                                }
                            }
    			)

	return 	tblGrid;		
}

function crearGridRegistrosCarpetasJudiciales(idMateria,tipoRegistros,idGrid)
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'carpetaAdministrativa'},
                                                                    {name: 'fracciones'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	
														chkRow,
                                                        {
															header:'Carpeta Judicial',
															width:140,
															sortable:true,
															dataIndex:'carpetaAdministrativa',
                                                            renderer:mostrarValorDescripcion
														},
														{
															header:'Fracciones',
															width:460,
															sortable:true,
															dataIndex:'fracciones',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	meta.attr='style="height: auto;min-height:21px;white-space: normal;"';
                                                                            	
                                                                    	var arrRegistros=[];
                                                                        if(idMateria=='1')
                                                                        {
                                                                        	if(tipoRegistros=='1')
                                                                            {
                                                                            	arrRegistros=arrMedidasCautelaresAdultos;
                                                                            }
                                                                            else	
                                                                            	arrRegistros=arrCondicionesSCAdultos;
                                                                        }
                                                                        else
                                                                        {
                                                                        	if(tipoRegistros=='1')
                                                                            {
                                                                            	arrRegistros=arrMedidasCautelaresAdolescentes;
                                                                            }
                                                                            else	
                                                                            	arrRegistros=arrCondicionesSCAdolescentes;
                                                                        }
                                                                        
                                                                        var lblLeyenda='';
                                                                        var lblAux='';
                                                                        var pos;
                                                                        var arrFracciones=eval(val);
                                                                        var x;
                                                                        for(x=0;x<arrFracciones.length;x++)
                                                                        {
                                                                        	pos=existeValorMatriz(arrRegistros,arrFracciones[x].idRegistro);
                                                                            lblAux=arrRegistros[pos][1];
                                                                            if(arrFracciones[x].detallesAdicionales!='')
                                                                            {
                                                                            	lblAux+='. '+arrFracciones[x].detallesAdicionales;
                                                                            }
                                                                            
                                                                            if(lblLeyenda=='')
                                                                            	lblLeyenda=lblAux;
                                                                            else
                                                                            	lblLeyenda+='<br> '+lblAux;
                                                                        }
                                                                        return lblLeyenda;
                                                                    }
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:idGrid,
                                                            store:alDatos,
                                                            frame:false,
                                                            y:40,
                                                            x:10,
                                                            disabled:true,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar registro',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaAgregarRegistro(idMateria,tipoRegistros,idGrid);
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover registro',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=gEx(idGrid).getSelectionModel.getSelections();
                                                                                        if(fila.length==0)
                                                                                        {
                                                                                        	msgBox('Debe selecionar los registros que desea remover');
                                                                                        	return;
                                                                                        }
                                                                                        gEx(idGrid).gerStore().remove(fila);
                                                                                        
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		],
                                                            columnLines : true,
                                                            height:260,
                                                            width:750,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;		
}

function mostrarVentanaAgregarRegistro(idMateria,tipoRegistros,idGrid)
{

	var carpetaAdministrativa='';
	var arrRegistros=[];
    if(idMateria=='1')
    {
        if(tipoRegistros=='1')
        {
            arrRegistros=arrMedidasCautelaresAdultos;
        }
        else	
            arrRegistros=arrCondicionesSCAdultos;
    }
    else
    {
        if(tipoRegistros=='1')
        {
            arrRegistros=arrMedidasCautelaresAdolescentes;
        }
        else	
            arrRegistros=arrCondicionesSCAdolescentes;
            
       	carpetaAdministrativa=  objGlobalInfoDocumento.carpetaAdministrativa; 
    }
    
     var oConf=	{
    					idCombo:'cmbCarpetaJudicial',
                        anchoCombo:200,
                        posX:130,
                        posY:5,
                        raiz:'registros',
                        campoDesplegar:'carpetaAdministrativa',
                        campoID:'carpetaAdministrativa',
                        funcionBusqueda:47,
                        paginaProcesamiento:'../paginasFunciones/funcionesModulosEspeciales_SGP.php',
                        confVista:'<tpl for="."><div class="search-item">{carpetaAdministrativa}<br></div></tpl>',
                        campos:	[
                                    {name:'carpetaAdministrativa'}

                                ],
                       	funcAntesCarga:function(dSet,combo)
                    				{
                                    	carpetaAdministrativa='';
                                    	var aValor=combo.getRawValue();
										dSet.baseParams.criterio=aValor;
                                        dSet.baseParams.tC='1,5,6';
                                        dSet.baseParams.uG='';
                                       
                                        
                                    },
                      	funcElementoSel:function(combo,registro)
                    				{
                                    	carpetaAdministrativa=registro.data.carpetaAdministrativa;
                                        
                                    }  
    				};

	var carpetaJudicial=crearComboExtAutocompletar(oConf)
    if(carpetaAdministrativa!='')
    {
    	gEx('cmbCarpetaJudicial').setValue(carpetaAdministrativa);
        gEx('cmbCarpetaJudicial').disable();
    }
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'<b>Carpeta Judicial:</b>'
                                                        },
                                                        carpetaJudicial,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Seleccione '+(tipoRegistros=='1'?'las medidas cautelares':'las condiciones de suspensi&oacute;n condicional de proceso:')+' que hayas sido impuestas al imputado:'
                                                        },
                                            			crearGridRegistros(arrRegistros,'grid_'+idMateria+'_'+tipoRegistros)
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar registro '+(tipoRegistros=='1'?' de medida cautelar':' condici&oacuten de suspensi&oacute;n condicional de proceso'),
										width: 820,
										height:420,
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
                                                                	gEx('cmbCarpetaJudicial').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		if(carpetaAdministrativa=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	gEx('cmbCarpetaJudicial').focus();
                                                                            }
                                                                            msgBox('Debe indicar la carpeta judicial sobre la cual fue impuesta '+(tipoRegistros=='1'?' las medidas cautelares':' condiciones de suspensi&oacute;n condicional de proceso'));
                                                                            return;
                                                                        }
                                                                        var cAdministrativa=carpetaAdministrativa;
                                                                        var reg=crearRegistro	(
                                                                        							[
                                                                                                    	{name: 'carpetaAdministrativa'},
                                                                   										{name: 'fracciones'}
                                                                        							]
                                                                                                )
                                                                        
                                                                        var listaFracciones='';
                                                                        var fila;
                                                                        var x;
                                                                        var grid=gEx('grid_'+idMateria+'_'+tipoRegistros);
                                                                        var oFraccion;
                                                                        for(x=0;x<grid.getStore().getCount();x++)
                                                                        {
                                                                        	fila=grid.getStore().getAt(x);

                                                                            if(fila.data.seleccionado)
                                                                            {
                                                                            	
                                                                            	oFraccion=	'{"idRegistro":"'+fila.data.idRegistro+'","detallesAdicionales":"'+cv(fila.data.detallesAdicionales,false,true)+'"}';
                                                                            	
                                                                                if(listaFracciones=='')
                                                                                    listaFracciones=oFraccion;
                                                                                else
                                                                                    listaFracciones+=','+oFraccion;
                                                                            }
                                                                        }
                                                                        
                                                                        var r=new reg 	(
                                                                        					{
                                                                                            	carpetaAdministrativa:cAdministrativa,
                                                                                                fracciones:'['+listaFracciones+']'
                                                                                            }
                                                                        				)
                                                                        gEx(idGrid).getStore().add(r);
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

function  mostrarInterfaceParametrosRespuestaSupervisionAdultos(cadObj,ventana)
{
	objGlobalInfoDocumento=eval('['+decodeURIComponent(cadObj)+']')[0];
	var arrTipoInforme=[['1','Seguimiento a medida cautelar'],['2','Seguimiento a medida de suspensi\xF3n condicional de proceso']];
	if(ventana)
		ventana.close();
	
    var cmbImputados=crearComboExt('cmbImputados',arrImputados,160,65,400,{multiSelect:false});
	if(cmbImputados.getStore().getCount()==1)
    {
    	var x=0;
    	cmbImputados.setValue(cmbImputados.getStore().getAt(x).data.id);
    }
    
    var cmbTipoInforme=crearComboExt('cmbTipoInforme',arrTipoInforme,210,265,450);
    cmbTipoInforme.on('select',function(cmb,registro)
    									{
                                        	gEx('tabRegistros').hideTabStripItem(1);
                                           	gEx('tabRegistros').hideTabStripItem(2);
                                        	switch(registro.data.id)
                                            {
                                            	case '1':
                                                	gEx('tabRegistros').unhideTabStripItem(1);
                                                    
                                                break;
                                                case '2':
                                                	gEx('tabRegistros').unhideTabStripItem(2);
                                                    
                                                    
                                                break;
                                            }
                                        }
    							)
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	xtype:'tabpanel',
                                                            region:'center',
                                                            id:'tabRegistros',
                                                            activeTab:0,
                                                            items:	[
                                                            			{
                                                                        	xtype:'panel',
                                                                            layout:'absolute',
                                                                            defaultType: 'label',
                                                                            title:'Datos Generales',
                                                                            items:	[
                                                                            			{
                                                                                            x:10,
                                                                                            y:10,
                                                                                            html:'<b>No de oficio a asignar:</b>'
                                                                                        },
                                                                                        {
                                                                                            x:160,
                                                                                            y:5,
                                                                                            xtype:'numberfield',
                                                                                            id:'txtNoOficioAsignar',
                                                                                            allowDecimals:false,
                                                                                            allowNegative:false,
                                                                                            width:100
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:40,
                                                                                            html:'<b>Carpeta Judicial:</b>'
                                                                                        },
                                                                                        {
                                                                                            x:160,
                                                                                            y:40,
                                                                                            html:'<span style="color: #900"><b>'+carpetaAdministrativa+'</b></span>'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:70,
                                                                                            html:'<b>Imputado:</b>'
                                                                                        },
                                                                                        cmbImputados,
                                                                                        
                                                                                        {
                                                                                            x:10,
                                                                                            y:100,
                                                                                            html:'<b>No de oficio que se responde:</b>'
                                                                                        },
                                                                                        
                                                                                        {
                                                                                            x:210,
                                                                                            y:95,
                                                                                            xtype:'textfield',
                                                                                            id:'txtNoOficio',
                                                                                            width:200
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:130,
                                                                                            html:'<b>Fecha del oficio que responde:</b>'
                                                                                        },
                                                                                        
                                                                                        {
                                                                                            x:210,
                                                                                            y:125,
                                                                                            xtype:'datefield',
                                                                                            id:'fechaOficio'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:160,
                                                                                            html:'<b>Fecha de viculaci&oacute;n a proceso:</b>'
                                                                                        },
                                                                                        
                                                                                        {
                                                                                            x:210,
                                                                                            y:155,
                                                                                            xtype:'datefield',
                                                                                            id:'fechaVinculacion'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:190,
                                                                                            html:'<b>Nombre destinatario:</b>'
                                                                                        },
                                                                                        {
                                                                                            x:210,
                                                                                            y:185,
                                                                                            width:350,
                                                                                            xtype:'textfield',
                                                                                            id:'nombreDestinatario'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:220,
                                                                                            html:'<b>Puesto destinatario:</b>'
                                                                                        },
                                                                                        {
                                                                                            x:210,
                                                                                            y:215,
                                                                                            width:450,
                                                                                            xtype:'textarea',
                                                                                            height:40,
                                                                                            id:'puestoDestinatario'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:270,
                                                                                            html:'<b>Tipo de informe a generar:</b>'
                                                                                        },
                                                                                        cmbTipoInforme
                                                                                        
                                                                            		]
                                                                        },
                                                                        {
                                                                        	xtype:'panel',
                                                                            layout:'absolute',
                                                                            defaultType: 'label',
                                                                            title:'Seguimiento a Medida Cautelar',
                                                                            items:	[
                                                                            			{
                                                                                        	x:10,
                                                                                            y:10,
                                                                                            html:'Indique las medidas cautelares cuyo informe desea generar:'
                                                                                        },
                                                                                        crearGridRegistrosSeguimiento(arrMedidasCautelaresAdultos,'gMC_18')
                                                                                        
                                                                            		]
                                                                        },
                                                                        {
                                                                        	xtype:'panel',
                                                                            layout:'absolute',
                                                                            defaultType: 'label',
                                                                            title:'Seguimiento a Condiciones de suspenci&oacute;n condicional de proceso',
                                                                            items:	[
                                                                            			{
                                                                                        	x:10,
                                                                                            y:10,
                                                                                            html:'Indique las condiciones de suspenci&oacute;n condicional de proceso cuyo informe desea generar:'
                                                                                        },
                                                                                        crearGridRegistrosSeguimiento(arrCondicionesSCAdultos,'gSC_18')
                                                                                        
                                                                            		]
                                                                        }
                                                            		]
                                                        }
                                            			
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Supervisi&oacute;n adultos',
										width: 880,
										height:450,
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
                                                                	gEx('txtNoOficioAsignar').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var txtNoOficioAsignar=gEx('txtNoOficioAsignar');
                                                                        var txtNoOficio=gEx('txtNoOficio');
                                                                        var imputados=cmbImputados.getValue();
                                                                        var txtNoOficio=gEx('txtNoOficio');
                                                                        var fechaOficio=gEx('fechaOficio');
                                                                        var fechaVinculacion=gEx('fechaVinculacion');
                                                                      	var nombreDestinatario=gEx('nombreDestinatario');
                                                                        var puestoDestinatario=gEx('puestoDestinatario');
                                                                        /*if(txtNoOficioAsignar.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	txtNoOficioAsignar.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el folio del oficio a asignar',resp1);
                                                                        	return;
                                                                        }*/
                                                                        
                                                                        if(imputados=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbImputados.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el imputado involucrado en el asunto',resp2);
                                                                        	return;
                                                                        }
                                                                        
                                                                        
                                                                        if(txtNoOficio.getValue()=='')
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	txtNoOficio.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el n&uacute;mero del oficio que responde',resp3);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(fechaOficio.getValue()=='')
                                                                        {
                                                                        	function resp4()
                                                                            {
                                                                            	fechaOficio.focus();
                                                                            }
                                                                        	msgBox('Debe indicar la fecha del oficio que responde',resp4);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(fechaVinculacion.getValue()=='')
                                                                        {
                                                                        	function resp5()
                                                                            {
                                                                            	fechaVinculacion.focus();
                                                                            }
                                                                        	msgBox('Debe indicar la fecha de vinculaci&oacute;n a proceso',resp5);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(nombreDestinatario.getValue()=='')
                                                                        {
                                                                        	function resp6()
                                                                            {
                                                                            	nombreDestinatario.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el nombre del destinatario del oficio',resp6);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(puestoDestinatario.getValue()=='')
                                                                        {
                                                                        	function resp7()
                                                                            {
                                                                            	puestoDestinatario.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el puesto del destinatario del oficio',resp7);
                                                                        	return;
                                                                        }
                                                                        
                                                                        
                                                                        if(cmbTipoInforme.getValue()=='')
                                                                        {
                                                                        	function resp8()
                                                                            {
                                                                            	cmbTipoInforme.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el tipo de informe a generar',resp8);
                                                                        	return;
                                                                        }
                                                                        
                                                                        var gridDestino;
                                                                        var tipoGridActivo;
                                                                        if(cmbTipoInforme.getValue()=='1')
                                                                        {
                                                                        	gridDestino=gEx('gMC_18');
                                                                        	if(gridDestino.getStore().getCount()==0)
                                                                            {
                                                                                function resp10()
                                                                                {
                                                                                    gEx('tabRegistros').setActiveTab(1);
                                                                                    tipoGridActivo=1;
                                                                                }
                                                                                msgBox('Debe indicar el resultado del seguimiento de las medidas cautelares',resp10);
                                                                                return;
                                                                            }
                                                                        }
                                                                        
                                                                        if(cmbTipoInforme.getValue()=='2')
                                                                        {
                                                                        	gridDestino=gEx('gSC_18');
                                                                        	if(gridDestino.getStore().getCount()==0)
                                                                        	{
                                                                                function resp102()
                                                                                {
                                                                                    gEx('tabRegistros').setActiveTab(2);
                                                                                    tipoGridActivo=2;
                                                                                }
                                                                                msgBox('Debe indicar el resultado del seguimiento de las condicionales de suspensi&oacuten condicional de proceso',resp102);
                                                                                return;
                                                                            }
                                                                        }
                                                                        var o='';
                                                                        var listaSeguimiento='';
                                                                       
                                                                        var fila;
                                                                        var x;
                                                                        
                                                                        for(x=0;x<gridDestino.getStore().getCount();x++)
                                                                        {
                                                                        	fila=gridDestino.getStore().getAt(x);
                                                                            if(fila.data.seleccionado)
                                                                            {
                                                                                o='{"idRegistro":"'+fila.data.idRegistro+'","fracciones":"'+
                                                                                	fila.data.fraccion+'","resultadoSeguimiento":"'+cv(fila.data.seguimiento)+'"}';
                                                                                if(listaSeguimiento=='')
                                                                                    listaSeguimiento=o;
                                                                                else
                                                                                    listaSeguimiento+=','+o;
                                                                            }
                                                                            
                                                                        }
                                                                        
                                                                        
                                                                        
                                                                        
                                                                       
	
                                                                        var cadParametros='{"noOficioAsignar":"'+txtNoOficioAsignar.getValue()+'","carpetaJudicial":"'+
                                                                        					carpetaAdministrativa+'","idCarpeta":"'+idCarpeta+'","imputados":"'+imputados+
                                                                                            '","oficioResponde":"'+cv(txtNoOficio.getValue())+'","fechaOficioResponde":"'+
                                                                                            fechaOficio.getValue().format('Y-m-d')+'","fechaVinculacionProceso":"'+
                                                                                            fechaVinculacion.getValue().format('Y-m-d')+'","nombreDestinatario":"'+
                                                                                            cv(nombreDestinatario.getValue())+'","puestoDestinatario":"'+cv(puestoDestinatario.getValue())+
                                                                                            '","tipoInforme":"'+cmbTipoInforme.getValue()+'","listaSeguimiento":['+listaSeguimiento+']}';
                                                                        
																	
                                                                    	guardarDatosDocumento(cadObj,cadParametros,ventanaAM);
                                                                    
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
                                
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var objInfo=eval(arrResp[1])[0];
            cmbImputados.setValue(objInfo.imputado);
            gEx('txtNoOficio').setValue(objInfo.noOficioResponde);
            gEx('fechaOficio').setValue(objInfo.fechaOficio);
            gEx('fechaVinculacion').setValue(objInfo.fechaVinculacionProceso);
            gEx('nombreDestinatario').setValue(objInfo.nombreDestinatario);
            gEx('puestoDestinatario').setValue(objInfo.puestoDestinatario);
            ventanaAM.show();
            gEx('tabRegistros').hideTabStripItem(1);
            gEx('tabRegistros').hideTabStripItem(2);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_MedidasCautelares.php',funcAjax, 'POST','funcion=1&iR='+gE('iRegistroMedidaCautelar').value,true);                          
	
	

}

function  mostrarInterfaceParametrosRespuestaSupervisionAdolescentes(cadObj,ventana)
{
	objGlobalInfoDocumento=eval('['+decodeURIComponent(cadObj)+']')[0];
	var arrTipoInforme=[['1','Seguimiento a medida cautelar'],['2','Seguimiento a medida de suspensi\xF3n condicional de proceso']];
	if(ventana)
		ventana.close();
	
    var cmbImputados=crearComboExt('cmbImputados',arrImputados,160,65,400,{multiSelect:false});
	if(cmbImputados.getStore().getCount()==1)
    {
    	var x=0;
    	cmbImputados.setValue(cmbImputados.getStore().getAt(x).data.id);
    }
    var cmbAudienciaMedidasCautelares=crearComboExt('cmbAudienciaMedidasCautelares',arrAudienciasCarpeta,10,215,600);
    var cmbTipoInforme=crearComboExt('cmbTipoInforme',arrTipoInforme,210,325,450);
    cmbTipoInforme.on('select',function(cmb,registro)
    									{
                                        	gEx('tabRegistros').hideTabStripItem(1);
                                           	gEx('tabRegistros').hideTabStripItem(2);
                                        	switch(registro.data.id)
                                            {
                                            	case '1':
                                                	gEx('tabRegistros').unhideTabStripItem(1);
                                                    
                                                break;
                                                case '2':
                                                	gEx('tabRegistros').unhideTabStripItem(2);
                                                    
                                                    
                                                break;
                                            }
                                        }
    							)
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	xtype:'tabpanel',
                                                            region:'center',
                                                            id:'tabRegistros',
                                                            activeTab:0,
                                                            items:	[
                                                            			{
                                                                        	xtype:'panel',
                                                                            layout:'absolute',
                                                                            defaultType: 'label',
                                                                            title:'Datos Generales',
                                                                            items:	[
                                                                            			{
                                                                                            x:10,
                                                                                            y:10,
                                                                                            html:'<b>No de oficio a asignar:</b>'
                                                                                        },
                                                                                        {
                                                                                            x:160,
                                                                                            y:5,
                                                                                            xtype:'numberfield',
                                                                                            id:'txtNoOficioAsignar',
                                                                                            allowDecimals:false,
                                                                                            allowNegative:false,
                                                                                            width:100
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:40,
                                                                                            html:'<b>Carpeta Judicial:</b>'
                                                                                        },
                                                                                        {
                                                                                            x:160,
                                                                                            y:40,
                                                                                            html:'<span style="color: #900"><b>'+carpetaAdministrativa+'</b></span>'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:70,
                                                                                            html:'<b>Imputado:</b>'
                                                                                        },
                                                                                        cmbImputados,
                                                                                        
                                                                                        {
                                                                                            x:10,
                                                                                            y:100,
                                                                                            html:'<b>No de oficio que se responde:</b>'
                                                                                        },
                                                                                        
                                                                                        {
                                                                                            x:210,
                                                                                            y:95,
                                                                                            xtype:'textfield',
                                                                                            id:'txtNoOficio',
                                                                                            width:200
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:130,
                                                                                            html:'<b>Fecha del oficio que responde:</b>'
                                                                                        },
                                                                                        
                                                                                        {
                                                                                            x:210,
                                                                                            y:125,
                                                                                            xtype:'datefield',
                                                                                            id:'fechaOficio'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:160,
                                                                                            html:'<b>Fecha de viculaci&oacute;n a proceso:</b>'
                                                                                        },
                                                                                        
                                                                                        {
                                                                                            x:210,
                                                                                            y:155,
                                                                                            xtype:'datefield',
                                                                                            id:'fechaVinculacion'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:190,
                                                                                            html:'<b>Audiencia en la que se impusieron las condiciones de suspensi&oacute;n condicional de proceso / medidas cautelares:</b>'
                                                                                        },
                                                                                        cmbAudienciaMedidasCautelares,
                                                                                        {
                                                                                            x:10,
                                                                                            y:250,
                                                                                            html:'<b>Nombre destinatario:</b>'
                                                                                        },
                                                                                        {
                                                                                            x:210,
                                                                                            y:245,
                                                                                            width:350,
                                                                                            xtype:'textfield',
                                                                                            id:'nombreDestinatario'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:280,
                                                                                            html:'<b>Puesto destinatario:</b>'
                                                                                        },
                                                                                        {
                                                                                            x:210,
                                                                                            y:275,
                                                                                            width:450,
                                                                                            xtype:'textarea',
                                                                                            height:40,
                                                                                            id:'puestoDestinatario'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:330,
                                                                                            html:'<b>Tipo de informe a generar:</b>'
                                                                                        },
                                                                                        cmbTipoInforme
                                                                                        
                                                                            		]
                                                                        },
                                                                        {
                                                                        	xtype:'panel',
                                                                            layout:'absolute',
                                                                            defaultType: 'label',
                                                                            title:'Seguimiento a Medida Cautelar',
                                                                            items:	[
                                                                            			{
                                                                                        	x:10,
                                                                                            y:10,
                                                                                            html:'Indique las medidas cautelares cuyo informe desea generar:'
                                                                                        },
                                                                                        crearGridRegistrosSeguimiento(arrMedidasCautelaresAdolescentes,'gMC_17')
                                                                                        
                                                                            		]
                                                                        },
                                                                        {
                                                                        	xtype:'panel',
                                                                            layout:'absolute',
                                                                            defaultType: 'label',
                                                                            title:'Seguimiento a Condiciones de suspenci&oacute;n condicional de proceso',
                                                                            items:	[
                                                                            			{
                                                                                        	x:10,
                                                                                            y:10,
                                                                                            html:'Indique las condiciones de suspenci&oacute;n condicional de proceso cuyo informe desea generar:'
                                                                                        },
                                                                                        crearGridRegistrosSeguimiento(arrCondicionesSCAdolescentes,'gSC_17')
                                                                                        
                                                                            		]
                                                                        }
                                                            		]
                                                        }
                                            			
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Supervisi&oacute;n adolescentes',
										width: 880,
										height:470,
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
                                                                	gEx('txtNoOficioAsignar').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var txtNoOficioAsignar=gEx('txtNoOficioAsignar');
                                                                        var txtNoOficio=gEx('txtNoOficio');
                                                                        var imputados=cmbImputados.getValue();
                                                                        var txtNoOficio=gEx('txtNoOficio');
                                                                        var fechaOficio=gEx('fechaOficio');
                                                                        var fechaVinculacion=gEx('fechaVinculacion');
                                                                      	var nombreDestinatario=gEx('nombreDestinatario');
                                                                        var puestoDestinatario=gEx('puestoDestinatario');
                                                                        /*if(txtNoOficioAsignar.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	txtNoOficioAsignar.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el folio del oficio a asignar',resp1);
                                                                        	return;
                                                                        }
                                                                        */
                                                                        if(imputados=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbImputados.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el imputado involucrado en el asunto',resp2);
                                                                        	return;
                                                                        }
                                                                        
                                                                        
                                                                        if(txtNoOficio.getValue()=='')
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	txtNoOficio.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el n&uacute;mero del oficio que responde',resp3);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(fechaOficio.getValue()=='')
                                                                        {
                                                                        	function resp4()
                                                                            {
                                                                            	fechaOficio.focus();
                                                                            }
                                                                        	msgBox('Debe indicar la fecha del oficio que responde',resp4);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(fechaVinculacion.getValue()=='')
                                                                        {
                                                                        	function resp5()
                                                                            {
                                                                            	fechaVinculacion.focus();
                                                                            }
                                                                        	msgBox('Debe indicar la fecha de vinculaci&oacute;n a proceso',resp5);
                                                                        	return;
                                                                        }
                                                                        
                                                                        
                                                                        if(cmbAudienciaMedidasCautelares.getValue()=='')
                                                                        {
                                                                        	function resp20()
                                                                            {
                                                                            	cmbAudienciaMedidasCautelares.focus();
                                                                            }
                                                                        	msgBox('Debe indicar la audiencia en la cual se impusieron las condiciones de suspensi&oacute;n condicional de proceso / medidas cautelares',resp20);
                                                                        	return;
                                                                        }
                                                                        
                                                                        
                                                                        if(nombreDestinatario.getValue()=='')
                                                                        {
                                                                        	function resp6()
                                                                            {
                                                                            	nombreDestinatario.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el nombre del destinatario del oficio',resp6);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(puestoDestinatario.getValue()=='')
                                                                        {
                                                                        	function resp7()
                                                                            {
                                                                            	puestoDestinatario.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el puesto del destinatario del oficio',resp7);
                                                                        	return;
                                                                        }
                                                                        
                                                                        
                                                                        if(cmbTipoInforme.getValue()=='')
                                                                        {
                                                                        	function resp8()
                                                                            {
                                                                            	cmbTipoInforme.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el tipo de informe a generar',resp8);
                                                                        	return;
                                                                        }
                                                                        
                                                                        var gridDestino;
                                                                        var tipoGridActivo;
                                                                        if(cmbTipoInforme.getValue()=='1')
                                                                        {
                                                                        	gridDestino=gEx('gMC_17');
                                                                        	if(gridDestino.getStore().getCount()==0)
                                                                            {
                                                                                function resp10()
                                                                                {
                                                                                    gEx('tabRegistros').setActiveTab(1);
                                                                                    tipoGridActivo=1;
                                                                                }
                                                                                msgBox('Debe indicar el resultado del seguimiento de las medidas cautelares',resp10);
                                                                                return;
                                                                            }
                                                                        }
                                                                        
                                                                        if(cmbTipoInforme.getValue()=='2')
                                                                        {
                                                                        	gridDestino=gEx('gSC_17');
                                                                        	if(gridDestino.getStore().getCount()==0)
                                                                        	{
                                                                                function resp102()
                                                                                {
                                                                                    gEx('tabRegistros').setActiveTab(2);
                                                                                    tipoGridActivo=2;
                                                                                }
                                                                                msgBox('Debe indicar el resultado del seguimiento de las condicionales de suspensi&oacuten condicional de proceso',resp102);
                                                                                return;
                                                                            }
                                                                        }
                                                                        var o='';
                                                                        var listaSeguimiento='';
                                                                       
                                                                        var fila;
                                                                        var x;
                                                                        
                                                                        for(x=0;x<gridDestino.getStore().getCount();x++)
                                                                        {
                                                                        	fila=gridDestino.getStore().getAt(x);
                                                                            if(fila.data.seleccionado)
                                                                            {
                                                                                o='{"idRegistro":"'+fila.data.idRegistro+'","fracciones":"'+
                                                                                	fila.data.fraccion+'","resultadoSeguimiento":"'+cv(fila.data.seguimiento)+'"}';
                                                                                if(listaSeguimiento=='')
                                                                                    listaSeguimiento=o;
                                                                                else
                                                                                    listaSeguimiento+=','+o;
                                                                            }
                                                                            
                                                                        }
                                                                        
                                                                        
                                                                        
                                                                        
                                                                       
	
                                                                        var cadParametros='{"noOficioAsignar":"'+txtNoOficioAsignar.getValue()+'","carpetaJudicial":"'+
                                                                        					carpetaAdministrativa+'","idCarpeta":"'+idCarpeta+'","imputados":"'+imputados+
                                                                                            '","oficioResponde":"'+cv(txtNoOficio.getValue())+'","fechaOficioResponde":"'+
                                                                                            fechaOficio.getValue().format('Y-m-d')+'","fechaVinculacionProceso":"'+
                                                                                            fechaVinculacion.getValue().format('Y-m-d')+'","nombreDestinatario":"'+
                                                                                            cv(nombreDestinatario.getValue())+'","puestoDestinatario":"'+cv(puestoDestinatario.getValue())+
                                                                                            '","tipoInforme":"'+cmbTipoInforme.getValue()+
                                                                                            '","listaSeguimiento":['+listaSeguimiento+'],"audienciaImposicion":"'+
                                                                                            cmbAudienciaMedidasCautelares.getValue()+'"}';
                                                                        
																	
                                                                    	guardarDatosDocumento(cadObj,cadParametros,ventanaAM);
                                                                    
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
                                
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var objInfo=eval(arrResp[1])[0];
            cmbImputados.setValue(objInfo.imputado);
            gEx('txtNoOficio').setValue(objInfo.noOficioResponde);
            gEx('fechaOficio').setValue(objInfo.fechaOficio);
            gEx('fechaVinculacion').setValue(objInfo.fechaVinculacionProceso);
            gEx('nombreDestinatario').setValue(objInfo.nombreDestinatario);
            gEx('puestoDestinatario').setValue(objInfo.puestoDestinatario);
            ventanaAM.show();
            gEx('tabRegistros').hideTabStripItem(1);
            gEx('tabRegistros').hideTabStripItem(2);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_MedidasCautelares.php',funcAjax, 'POST','funcion=1&iR='+gE('iRegistroMedidaCautelar').value,true);                          
	
	

}

function crearGridRegistrosSeguimiento(arrDatos,idGrid)
{
	var dsDatos=arrDatos;
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idRegistro'},
                                                                    {name: 'leyenda'},
                                                                    {name: 'fraccion'},
                                                                    {name: 'seleccionado'},
                                                                    {name: 'seguimiento'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	
    var checkColumn = new Ext.grid.CheckColumn	(
	 												{
													   header: '',
													   dataIndex: 'seleccionado',
													   width: 30
													}
												);
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	
														checkColumn,
														{
															header:'Fracci&oacute;n',
															width:300,
															sortable:true,
															dataIndex:'leyenda',
                                                            renderer:function(val,meta,registro)
                                                            				{
                                                                            	meta.attr='style="height: auto;min-height:21px;white-space: normal;"';
                                                                            	return mostrarValorDescripcion(val);
                                                                            }
														},
														{
															header:'Seguimiento',
															width:450,
															sortable:true,
															dataIndex:'seguimiento',
                                                            renderer:function(val,meta,registro)
                                                            				{
                                                                            	meta.attr='style="height: auto;min-height:21px;white-space: normal;"';
                                                                            	return mostrarValorDescripcion(escaparEnter(val,true));
                                                                            },
                                                            editor:{xtype:'textarea',height:60}
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:idGrid,
                                                            store:alDatos,
                                                            frame:false,
                                                            y:40,
                                                            x:10,
                                                            clicksToEdit:1,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,                                                            
                                                            columnLines : true,
                                                            height:280,
                                                            plugins:[checkColumn],
                                                            width:825
                                                        }
                                                    );
                                                    
	tblGrid.on('beforeedit',function(e)
    						{
                            	if((e.field=='seguimiento')&&(!e.record.data.seleccionado))
                                {
                                	e.cancel=true;
                                    return;
                                }
                            }
    			)                                                    
	
    tblGrid.on('afteredit',function(e)
    						{
                            	if((e.field=='seleccionado')&&(!e.record.data.seleccionado))
                                {
                                	e.record.set('seguimiento','');

                                }
                            }
    			) 
                                                        
	return 	tblGrid;		
}

function  mostrarInterfaceParametrosSobreseimientoAdolescentes(cadObj,ventana)
{
	objGlobalInfoDocumento=eval('['+decodeURIComponent(cadObj)+']')[0];
	if(ventana)
		ventana.close();
	var cmbAudienciaSobreseimiento=crearComboExt('cmbAudienciaSobreseimiento',arrAudienciasCarpeta,335,95,400);
    cmbAudienciaSobreseimiento.setValue(idAudienciaSobreseimiento);
    
    var cmbMostrarVictima=crearComboExt('cmbMostrarVictima',arrMostrarVictima,180,125,400);
    cmbMostrarVictima.setValue('1');
    var cmbImputados=crearComboExt('cmbImputados',arrImputados,160,65,300,{multiSelect:true});
	if(cmbImputados.getStore().getCount()==1)
    {
    	var x=0;
    	cmbImputados.setValue(cmbImputados.getStore().getAt(x).data.id);
    }
    
    
    var cmbFirmante=crearComboExt('cmbFirmante',arrFirmantes,180,155,400);
    if(arrFirmantes.length>0)
	    cmbFirmante.setValue(arrFirmantes[0][0]);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'<b>No de oficio a asignar:</b>'
                                                        },
                                                        {
                                                        	x:160,
                                                            y:5,
                                                            xtype:'numberfield',
                                                            id:'txtNoOficioAsignar',
                                                            allowDecimals:false,
                                                            allowNegative:false,
                                                            width:100
                                                        },
                                            			{
                                                        	x:10,
                                                            y:40,
                                                            html:'<b>Carpeta Judicial:</b>'
                                                        },
                                                        {
                                                        	x:160,
                                                            y:40,
                                                            html:'<span style="color: #900"><b>'+carpetaAdministrativa+'</b></span>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'<b>Imputados:</b>'
                                                        },
                                                        cmbImputados,
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            html:'<b>Audiencia en la cual se determina el sobreseimiento:</b>'
                                                        },
                                                        cmbAudienciaSobreseimiento,
                                                         
                                                        {
                                                        	x:10,
                                                            y:130,
                                                            html:'<b>Mostrar v&iacute;ctimas como:</b>'
                                                        },
                                                        cmbMostrarVictima,
                                                        {
                                                        	x:10,
                                                            y:160,
                                                            html:'<b>Firmado por:</b>'
                                                        },
                                                        cmbFirmante
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Se informa sobreseimiento',
										width: 810,
										height:300,
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
                                                                	gEx('txtNoOficioAsignar').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var txtNoOficioAsignar=gEx('txtNoOficioAsignar');
                                                                        var txtNoOficio=gEx('txtNoOficio');
                                                                        var imputados=cmbImputados.getValue();
                                                                        
                                                                        if(txtNoOficioAsignar.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	txtNoOficioAsignar.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el folio del oficio a asignar',resp1);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(imputados=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbImputados.focus();
                                                                            }
                                                                        	msgBox('Debe indicar almenos un imputado involucrado en el asunto',resp2);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(cmbAudienciaSobreseimiento.getValue()=='')
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	cmbAudienciaSobreseimiento.focus();
                                                                            }
                                                                        	msgBox('Debe indicar la audiencia en la cual se determina el sobreseimiento',resp3);
                                                                        	return;
                                                                        }
                                                                        
                                                                       
                                                                        
                                                                        if(cmbFirmante.getValue()=='')
                                                                        {
                                                                        	function resp6()
                                                                            {
                                                                            	cmbFirmante.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el nombre del firmante del oficio',resp6);
                                                                        	return;
                                                                        }

                                                                        var cadParametros='{"noOficioAsignar":"'+txtNoOficioAsignar.getValue()+'","carpetaJudicial":"'+
                                                                        					carpetaAdministrativa+'","idCarpeta":"'+idCarpeta+'","imputados":"'+imputados+
                                                                                            '","audienciaSobreseimiento":"'+cmbAudienciaSobreseimiento.getValue()+
                                                                                            '","mostrarVictimasComo":"'+cmbMostrarVictima.getValue()+'","firmante":"'+
                                                                                            cmbFirmante.getValue()+'"}';
                                                                        
																	
                                                                    	guardarDatosDocumento(cadObj,cadParametros,ventanaAM);
                                                                    
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

function  mostrarInterfaceParametrosSCPAdolescentes(cadObj,ventana)
{
	objGlobalInfoDocumento=eval('['+decodeURIComponent(cadObj)+']')[0];
	if(ventana)
		ventana.close();
	
    var cmbImputados=crearComboExt('cmbImputados',arrImputados,160,65,400,{multiSelect:false});
	if(cmbImputados.getStore().getCount()==1)
    {
    	var x=0;
    	cmbImputados.setValue(cmbImputados.getStore().getAt(x).data.id);
    }
    var arrPeridoPresentacion=[['1','Periodo'],['2','Fecha']];
    var cmbPeriodo=crearComboExt('cmbPeriodo',arrPeridoPresentacion,250,185,110);
    cmbPeriodo.setValue('2');
    cmbPeriodo.on('select',function(cmb,registro)
    						{
                            	if(registro.data.id=='2')
                                {
                                	
                                    gEx('periodoPresentacionImputado').hide();
                                	gEx('cmbPeriodoPresentacion').hide();
                                    gEx('fechaPresentacionImputado').show();
                                }
                                else
                                {
                                	gEx('periodoPresentacionImputado').show();
                                	gEx('cmbPeriodoPresentacion').show();
                                    gEx('fechaPresentacionImputado').hide();
                                }
                            }
    			)
    var cmbJuezFirmante=crearComboExt('cmbJuezFirmante',arrJueces,160,245,350);
    var arrPeriodoPresentacion=[['1','Horas'],['2','Dias'],['3','Meses'],['4','A\xF1os']];
    var cmbPeriodoPresentacion=crearComboExt('cmbPeriodoPresentacion',arrPeriodoPresentacion,440,185,120);
    cmbPeriodoPresentacion.setValue('2');
    cmbPeriodoPresentacion.hide();
    var cmbAudiencia=crearComboExt('cmbAudiencia',arrAudienciasCarpeta,250,95,400);
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	xtype:'tabpanel',
                                                            region:'center',
                                                            id:'tabRegistros',
                                                            activeTab:0,
                                                            items:	[
                                                            			{
                                                                        	xtype:'panel',
                                                                            layout:'absolute',
                                                                            defaultType: 'label',
                                                                            title:'Datos Generales',
                                                                            items:	[
                                                                            			{
                                                                                            x:10,
                                                                                            y:10,
                                                                                            html:'<b>No de oficio a asignar:</b>'
                                                                                        },
                                                                                        {
                                                                                            x:160,
                                                                                            y:5,
                                                                                            xtype:'numberfield',
                                                                                            id:'txtNoOficioAsignar',
                                                                                            allowDecimals:false,
                                                                                            allowNegative:false,
                                                                                            width:100
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:40,
                                                                                            html:'<b>Carpeta Judicial:</b>'
                                                                                        },
                                                                                        {
                                                                                            x:160,
                                                                                            y:40,
                                                                                            html:'<span style="color: #900"><b>'+carpetaAdministrativa+'</b></span>'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:70,
                                                                                            html:'<b>Imputado:</b>'
                                                                                        },
                                                                                        cmbImputados,
                                                                                        {
                                                                                            x:10,
                                                                                            y:100,
                                                                                            html:'<b>Audiencia en la cual se concede:</b>'
                                                                                        },
                                                                                        cmbAudiencia,
                                                                                        {
                                                                                            x:10,
                                                                                            y:130,
                                                                                            html:'<b>Periodo de suspensi&oacute;n:</b>'
                                                                                        },
                                                                                        {
                                                                                        	x:160,
                                                                                            y:125,
                                                                                            xtype:'numberfield',
                                                                                            width:60,
                                                                                            allowDecimals:false,
                                                                                            allowNegative:false,
                                                                                            id:'txtPeriodo'
                                                                                           
                                                                                        },
                                                                                        {
                                                                                            x:230,
                                                                                            y:130,
                                                                                            html:'<b>meses</b>'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:160,
                                                                                            html:'<b>Fecha de fenecimiento:</b>'
                                                                                        },
                                                                                        {
                                                                                        	x:160,
                                                                                            y:155,
                                                                                            xtype:'datefield',
                                                                                            
                                                                                            id:'fechaFenecimiento'
                                                                                           
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:190,
                                                                                            html:'<b>Presentaci&oacute;n de imputado ante unidad:</b>'
                                                                                        },
                                                                                        cmbPeriodo,
                                                                                        {
                                                                                        	x:375,
                                                                                            y:185,
                                                                                            xtype:'datefield',
                                                                                            
                                                                                            id:'fechaPresentacionImputado'
                                                                                           
                                                                                        },
                                                                                        {
                                                                                        	x:375,
                                                                                            y:185,
                                                                                            width:50,
                                                                                            hidden:true,
                                                                                            id:'periodoPresentacionImputado',
                                                                                            xtype:'numberfield',
                                                                                            allowDecimals:false,
                                                                                            allowNegative:false
                                                                                        },
                                                                                        cmbPeriodoPresentacion,
                                                                                        {
                                                                                            x:10,
                                                                                            y:220,
                                                                                            html:'<b>Plazo reporte incumplimiento:</b>'
                                                                                        },
                                                                                        {
                                                                                        	x:250,
                                                                                            y:215,
                                                                                            xtype:'numberfield',
                                                                                            width:60,
                                                                                            allowDecimals:false,
                                                                                            allowNegative:false,
                                                                                            id:'txtPlazoDias'
                                                                                           
                                                                                        },
                                                                                        {
                                                                                            x:320,
                                                                                            y:220,
                                                                                            html:'<b>dias</b>'
                                                                                        },
                                                                                        
                                                                                        {
                                                                                            x:10,
                                                                                            y:250,
                                                                                            html:'<b>Juez informante:</b>'
                                                                                        },
                                                                                        cmbJuezFirmante
                                                                            		]
                                                                        },
                                                                        
                                                                        {
                                                                        	xtype:'panel',
                                                                            layout:'absolute',
                                                                            defaultType: 'label',
                                                                            title:'Condiciones de suspenci&oacute;n condicional de proceso',
                                                                            items:	[
                                                                            			{
                                                                                        	x:10,
                                                                                            y:10,
                                                                                            html:'Seleccione las condiciones de suspenci&oacute;n condicional de proceso que apliquen:'
                                                                                        },
                                                                                        crearGridRegistrosSCPAdolescente()
                                                                                        
                                                                                        
                                                                            		]
                                                                        }
                                                            		]
                                                        }
                                            			
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Se concede SCP',
										width: 810,
										height:430,
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
                                                                	gEx('txtNoOficioAsignar').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var txtNoOficioAsignar=gEx('txtNoOficioAsignar');
                                                                        var imputados=cmbImputados.getValue();
                                                                        var txtPeriodo=gEx('txtPeriodo');
                                                                        var fechaFenecimiento=gEx('fechaFenecimiento');
                                                                        var txtPlazoDias=gEx('txtPlazoDias');
                                                                        
                                                                        if(txtNoOficioAsignar.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	gEx('tabRegistros').setActiveTab(0);
                                                                            	txtNoOficioAsignar.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el folio del oficio a asignar',resp1);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(imputados=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	gEx('tabRegistros').setActiveTab(0);
                                                                            	cmbImputados.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el imputado involucrado en el asunto',resp2);
                                                                        	return;
                                                                        }
                                                                        
                                                                        
                                                                        if(cmbAudiencia.getValue()=='')
                                                                        {
                                                                        	function resp200()
                                                                            {
                                                                            	gEx('tabRegistros').setActiveTab(0);
                                                                            	cmbAudiencia.focus();
                                                                            }
                                                                        	msgBox('Debe indicar la audiencia en la cual se concede la suspensi&oacute;n condicional de proceso',resp200);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(txtPeriodo.getValue()=='')
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	gEx('tabRegistros').setActiveTab(0);
                                                                            	txtPeriodo.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el periodo de suspensi&oacute;n condicional de proceso',resp3);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(fechaFenecimiento.getValue()=='')
                                                                        {
                                                                        	function resp4()
                                                                            {
                                                                            	gEx('tabRegistros').setActiveTab(0);
                                                                            	fechaFenecimiento.focus();
                                                                            }
                                                                        	msgBox('Debe indicar la fecha de fenecimiento de la suspensi&oacute;n condicional de proceso',resp4);
                                                                        	return;
                                                                        }
                                                                        
                                                                        
                                                                        if(cmbPeriodo.getValue()=='')
                                                                        {
                                                                        	function resp8()
                                                                            {
                                                                            	gEx('tabRegistros').setActiveTab(0);
                                                                            	cmbPeriodo.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el periodo en el cual el adolescente debe presentarse ante la unidad',resp8);
                                                                        	return;
                                                                        }
                                                                        var periodoPresentacionImputado=gEx('periodoPresentacionImputado');
                                                                        var fechaPresentacionImputado=gEx('fechaPresentacionImputado');
                                                                        if(cmbPeriodo.getValue()=='2')
                                                                        {
                                                                        	if(fechaPresentacionImputado.getValue()=='')
                                                                            {
                                                                                function resp9()
                                                                                {
                                                                                    gEx('tabRegistros').setActiveTab(0);
                                                                                    fechaPresentacionImputado.focus();
                                                                                }
                                                                                msgBox('Debe indicar la fecha l&iacute;mite en la cual el adolescente debe presentarse ante la unidad',resp9);
                                                                                return;
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                        	if(periodoPresentacionImputado.getValue()=='')
                                                                            {
                                                                                function resp10()
                                                                                {
                                                                                    gEx('tabRegistros').setActiveTab(0);
                                                                                    periodoPresentacionImputado.focus();
                                                                                }
                                                                                msgBox('Debe indicar el periodo l&iacute;mite en el cual el adolescente debe presentarse ante la unidad',resp10);
                                                                                return;
                                                                            }
                                                                            
                                                                            if(cmbPeriodoPresentacion.getValue()=='')
                                                                            {
                                                                                function resp11()
                                                                                {
                                                                                    gEx('tabRegistros').setActiveTab(0);
                                                                                    cmbPeriodoPresentacion.focus();
                                                                                }
                                                                                msgBox('Debe indicar la periodicidad en la cual el adolescente debe presentarse ante la unidad',resp11);
                                                                                return;
                                                                            }
                                                                        }
                                                                        
                                                                        if(txtPlazoDias.getValue()=='')
                                                                        {
                                                                        	function resp5()
                                                                            {
                                                                            	gEx('tabRegistros').setActiveTab(0);
                                                                            	txtPlazoDias.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el plazo de notificaci&oacute;n en caso de incumplimeinto',resp5);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(cmbJuezFirmante.getValue()=='')
                                                                        {
                                                                        	function resp6()
                                                                            {
                                                                            	gEx('tabRegistros').setActiveTab(0);
                                                                            	cmbJuezFirmante.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el juez firmante del documento',resp6);
                                                                        	return;
                                                                        }
                                                                        
                                                                        var listaCondiciones='';
                                                                        
                                                                        var x;
                                                                        var fila;
                                                                        var o;
                                                                        for(x=0;x<gEx('gSuspencion').getStore().getCount();x++)
                                                                        {
                                                                        	fila=gEx('gSuspencion').getStore().getAt(x);
                                                                            o='{"idCondicion":"'+fila.data.idCondicion+'","detalles":"'+cv(fila.data.detallesAdicionales)+'"}';
                                                                            if(listaCondiciones=='')
                                                                            	listaCondiciones=o;
                                                                            else
                                                                            	listaCondiciones+=','+o
                                                                        }
                                                                        
                                                                        
                                                                        if(listaCondiciones=='')
                                                                        {
                                                                        	
                                                                        	function resp12()
                                                                            {
                                                                            	gEx('tabRegistros').setActiveTab(1);
                                                                            	
                                                                            }
                                                                        	msgBox('Debe indicar las condiciones de suspensi&oacute;n condicional de proceso',resp12);
                                                                        	return
                                                                        }
                                                                       
	
                                                                        var cadParametros='{"noOficioAsignar":"'+txtNoOficioAsignar.getValue()+'","carpetaJudicial":"'+
                                                                        					carpetaAdministrativa+'","idCarpeta":"'+idCarpeta+'","imputados":"'+imputados+
                                                                                            '","periodo":"'+cv(txtPeriodo.getValue())+'","fechaFenecimiento":"'+
                                                                                            fechaFenecimiento.getValue().format('Y-m-d')+'","suspencionesCondicional":['+
                                                                                            listaCondiciones+'],"plazoDias":"'+txtPlazoDias.getValue()+
                                                                                            '","usuarioDestinatario":"'+cmbJuezFirmante.getValue()+'","tipoPeriodoLimite":"'+
                                                                                            cmbPeriodo.getValue()+'","fechaLimite":"'+
                                                                                            (fechaPresentacionImputado.getValue()!=''?fechaPresentacionImputado.getValue().format('Y-m-d'):'')+
                                                                                            '","periodoLimite":"'+periodoPresentacionImputado.getValue()+
                                                                                            '","plazoPeriodoLimite":"'+cmbPeriodoPresentacion.getValue()+
                                                                                            '","audienciaConcede":"'+cmbAudiencia.getValue()+'"}';
                                                                        
																	
                                                                    	guardarDatosDocumento(cadObj,cadParametros,ventanaAM);
                                                                    
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

function  mostrarInterfaceParametrosSCPAdultos(cadObj,ventana)
{
	objGlobalInfoDocumento=eval('['+decodeURIComponent(cadObj)+']')[0];
	if(ventana)
		ventana.close();
	
    var cmbImputados=crearComboExt('cmbImputados',arrImputados,160,65,400,{multiSelect:false});
	if(cmbImputados.getStore().getCount()==1)
    {
    	var x=0;
    	cmbImputados.setValue(cmbImputados.getStore().getAt(x).data.id);
    }
    var arrPeridoPresentacion=[['1','Periodo'],['2','Fecha']];
    var cmbPeriodo=crearComboExt('cmbPeriodo',arrPeridoPresentacion,250,185,110);
    cmbPeriodo.setValue('2');
    cmbPeriodo.on('select',function(cmb,registro)
    						{
                            	if(registro.data.id=='2')
                                {
                                	
                                    gEx('periodoPresentacionImputado').hide();
                                	gEx('cmbPeriodoPresentacion').hide();
                                    gEx('fechaPresentacionImputado').show();
                                }
                                else
                                {
                                	gEx('periodoPresentacionImputado').show();
                                	gEx('cmbPeriodoPresentacion').show();
                                    gEx('fechaPresentacionImputado').hide();
                                }
                            }
    			)
    var cmbJuezFirmante=crearComboExt('cmbJuezFirmante',arrJueces,160,245,350);
    var arrPeriodoPresentacion=[['1','Horas'],['2','Dias'],['3','Meses'],['4','A\xF1os']];
    var cmbPeriodoPresentacion=crearComboExt('cmbPeriodoPresentacion',arrPeriodoPresentacion,440,185,120);
    cmbPeriodoPresentacion.setValue('2');
    cmbPeriodoPresentacion.hide();
    var cmbAudiencia=crearComboExt('cmbAudiencia',arrAudienciasCarpeta,250,95,400);
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	xtype:'tabpanel',
                                                            region:'center',
                                                            id:'tabRegistros',
                                                            activeTab:0,
                                                            items:	[
                                                            			{
                                                                        	xtype:'panel',
                                                                            layout:'absolute',
                                                                            defaultType: 'label',
                                                                            title:'Datos Generales',
                                                                            items:	[
                                                                            			{
                                                                                            x:10,
                                                                                            y:10,
                                                                                            html:'<b>No de oficio a asignar:</b>'
                                                                                        },
                                                                                        {
                                                                                            x:160,
                                                                                            y:5,
                                                                                            xtype:'numberfield',
                                                                                            id:'txtNoOficioAsignar',
                                                                                            allowDecimals:false,
                                                                                            allowNegative:false,
                                                                                            width:100
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:40,
                                                                                            html:'<b>Carpeta Judicial:</b>'
                                                                                        },
                                                                                        {
                                                                                            x:160,
                                                                                            y:40,
                                                                                            html:'<span style="color: #900"><b>'+carpetaAdministrativa+'</b></span>'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:70,
                                                                                            html:'<b>Imputado:</b>'
                                                                                        },
                                                                                        cmbImputados,
                                                                                        {
                                                                                            x:10,
                                                                                            y:100,
                                                                                            html:'<b>Audiencia en la cual se concede:</b>'
                                                                                        },
                                                                                        cmbAudiencia,
                                                                                        {
                                                                                            x:10,
                                                                                            y:130,
                                                                                            html:'<b>Periodo de suspensi&oacute;n:</b>'
                                                                                        },
                                                                                        {
                                                                                        	x:160,
                                                                                            y:125,
                                                                                            xtype:'numberfield',
                                                                                            width:60,
                                                                                            allowDecimals:false,
                                                                                            allowNegative:false,
                                                                                            id:'txtPeriodo'
                                                                                           
                                                                                        },
                                                                                        {
                                                                                            x:230,
                                                                                            y:130,
                                                                                            html:'<b>meses</b>'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:160,
                                                                                            html:'<b>Fecha de fenecimiento:</b>'
                                                                                        },
                                                                                        {
                                                                                        	x:160,
                                                                                            y:155,
                                                                                            xtype:'datefield',
                                                                                            
                                                                                            id:'fechaFenecimiento'
                                                                                           
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:190,
                                                                                            html:'<b>Presentaci&oacute;n de imputado ante unidad:</b>'
                                                                                        },
                                                                                        cmbPeriodo,
                                                                                        {
                                                                                        	x:375,
                                                                                            y:185,
                                                                                            xtype:'datefield',
                                                                                            
                                                                                            id:'fechaPresentacionImputado'
                                                                                           
                                                                                        },
                                                                                        {
                                                                                        	x:375,
                                                                                            y:185,
                                                                                            width:50,
                                                                                            hidden:true,
                                                                                            id:'periodoPresentacionImputado',
                                                                                            xtype:'numberfield',
                                                                                            allowDecimals:false,
                                                                                            allowNegative:false
                                                                                        },
                                                                                        cmbPeriodoPresentacion,
                                                                                        {
                                                                                            x:10,
                                                                                            y:220,
                                                                                            html:'<b>Plazo reporte incumplimiento:</b>'
                                                                                        },
                                                                                        {
                                                                                        	x:250,
                                                                                            y:215,
                                                                                            xtype:'numberfield',
                                                                                            width:60,
                                                                                            allowDecimals:false,
                                                                                            allowNegative:false,
                                                                                            id:'txtPlazoDias'
                                                                                           
                                                                                        },
                                                                                        {
                                                                                            x:320,
                                                                                            y:220,
                                                                                            html:'<b>dias</b>'
                                                                                        },
                                                                                        
                                                                                        {
                                                                                            x:10,
                                                                                            y:250,
                                                                                            html:'<b>Juez informante:</b>'
                                                                                        },
                                                                                        cmbJuezFirmante
                                                                            		]
                                                                        },
                                                                        
                                                                        {
                                                                        	xtype:'panel',
                                                                            layout:'absolute',
                                                                            defaultType: 'label',
                                                                            title:'Condiciones de suspenci&oacute;n condicional de proceso',
                                                                            items:	[
                                                                            			{
                                                                                        	x:10,
                                                                                            y:10,
                                                                                            html:'Seleccione las condiciones de suspenci&oacute;n condicional de proceso que apliquen:'
                                                                                        },
                                                                                        crearGridRegistrosSCPAdultos()
                                                                                        
                                                                                        
                                                                            		]
                                                                        }
                                                            		]
                                                        }
                                            			
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Se concede SCP',
										width: 810,
										height:430,
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
                                                                	gEx('txtNoOficioAsignar').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var txtNoOficioAsignar=gEx('txtNoOficioAsignar');
                                                                        var imputados=cmbImputados.getValue();
                                                                        var txtPeriodo=gEx('txtPeriodo');
                                                                        var fechaFenecimiento=gEx('fechaFenecimiento');
                                                                        var txtPlazoDias=gEx('txtPlazoDias');
                                                                        
                                                                        if(txtNoOficioAsignar.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	gEx('tabRegistros').setActiveTab(0);
                                                                            	txtNoOficioAsignar.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el folio del oficio a asignar',resp1);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(imputados=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	gEx('tabRegistros').setActiveTab(0);
                                                                            	cmbImputados.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el imputado involucrado en el asunto',resp2);
                                                                        	return;
                                                                        }
                                                                        
                                                                        
                                                                        if(cmbAudiencia.getValue()=='')
                                                                        {
                                                                        	function resp200()
                                                                            {
                                                                            	gEx('tabRegistros').setActiveTab(0);
                                                                            	cmbAudiencia.focus();
                                                                            }
                                                                        	msgBox('Debe indicar la audiencia en la cual se concede la suspensi&oacute;n condicional de proceso',resp200);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(txtPeriodo.getValue()=='')
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	gEx('tabRegistros').setActiveTab(0);
                                                                            	txtPeriodo.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el periodo de suspensi&oacute;n condicional de proceso',resp3);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(fechaFenecimiento.getValue()=='')
                                                                        {
                                                                        	function resp4()
                                                                            {
                                                                            	gEx('tabRegistros').setActiveTab(0);
                                                                            	fechaFenecimiento.focus();
                                                                            }
                                                                        	msgBox('Debe indicar la fecha de fenecimiento de la suspensi&oacute;n condicional de proceso',resp4);
                                                                        	return;
                                                                        }
                                                                        
                                                                        
                                                                        if(cmbPeriodo.getValue()=='')
                                                                        {
                                                                        	function resp8()
                                                                            {
                                                                            	gEx('tabRegistros').setActiveTab(0);
                                                                            	cmbPeriodo.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el periodo en el cual el adolescente debe presentarse ante la unidad',resp8);
                                                                        	return;
                                                                        }
                                                                        var periodoPresentacionImputado=gEx('periodoPresentacionImputado');
                                                                        var fechaPresentacionImputado=gEx('fechaPresentacionImputado');
                                                                        if(cmbPeriodo.getValue()=='2')
                                                                        {
                                                                        	if(fechaPresentacionImputado.getValue()=='')
                                                                            {
                                                                                function resp9()
                                                                                {
                                                                                    gEx('tabRegistros').setActiveTab(0);
                                                                                    fechaPresentacionImputado.focus();
                                                                                }
                                                                                msgBox('Debe indicar la fecha l&iacute;mite en la cual el adolescente debe presentarse ante la unidad',resp9);
                                                                                return;
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                        	if(periodoPresentacionImputado.getValue()=='')
                                                                            {
                                                                                function resp10()
                                                                                {
                                                                                    gEx('tabRegistros').setActiveTab(0);
                                                                                    periodoPresentacionImputado.focus();
                                                                                }
                                                                                msgBox('Debe indicar el periodo l&iacute;mite en el cual el adolescente debe presentarse ante la unidad',resp10);
                                                                                return;
                                                                            }
                                                                            
                                                                            if(cmbPeriodoPresentacion.getValue()=='')
                                                                            {
                                                                                function resp11()
                                                                                {
                                                                                    gEx('tabRegistros').setActiveTab(0);
                                                                                    cmbPeriodoPresentacion.focus();
                                                                                }
                                                                                msgBox('Debe indicar la periodicidad en la cual el adolescente debe presentarse ante la unidad',resp11);
                                                                                return;
                                                                            }
                                                                        }
                                                                        
                                                                        if(txtPlazoDias.getValue()=='')
                                                                        {
                                                                        	function resp5()
                                                                            {
                                                                            	gEx('tabRegistros').setActiveTab(0);
                                                                            	txtPlazoDias.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el plazo de notificaci&oacute;n en caso de incumplimeinto',resp5);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(cmbJuezFirmante.getValue()=='')
                                                                        {
                                                                        	function resp6()
                                                                            {
                                                                            	gEx('tabRegistros').setActiveTab(0);
                                                                            	cmbJuezFirmante.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el juez firmante del documento',resp6);
                                                                        	return;
                                                                        }
                                                                        
                                                                        var listaCondiciones='';
                                                                        
                                                                        var x;
                                                                        var fila;
                                                                        var o;
                                                                        for(x=0;x<gEx('gSuspencion').getStore().getCount();x++)
                                                                        {
                                                                        	fila=gEx('gSuspencion').getStore().getAt(x);
                                                                            o='{"idCondicion":"'+fila.data.idCondicion+'","detalles":"'+cv(fila.data.detallesAdicionales)+'"}';
                                                                            if(listaCondiciones=='')
                                                                            	listaCondiciones=o;
                                                                            else
                                                                            	listaCondiciones+=','+o
                                                                        }
                                                                        
                                                                        
                                                                        if(listaCondiciones=='')
                                                                        {
                                                                        	
                                                                        	function resp12()
                                                                            {
                                                                            	gEx('tabRegistros').setActiveTab(1);
                                                                            	
                                                                            }
                                                                        	msgBox('Debe indicar las condiciones de suspensi&oacute;n condicional de proceso',resp12);
                                                                        	return
                                                                        }
                                                                       
	
                                                                        var cadParametros='{"noOficioAsignar":"'+txtNoOficioAsignar.getValue()+'","carpetaJudicial":"'+
                                                                        					carpetaAdministrativa+'","idCarpeta":"'+idCarpeta+'","imputados":"'+imputados+
                                                                                            '","periodo":"'+cv(txtPeriodo.getValue())+'","fechaFenecimiento":"'+
                                                                                            fechaFenecimiento.getValue().format('Y-m-d')+'","suspencionesCondicional":['+
                                                                                            listaCondiciones+'],"plazoDias":"'+txtPlazoDias.getValue()+
                                                                                            '","usuarioDestinatario":"'+cmbJuezFirmante.getValue()+'","tipoPeriodoLimite":"'+
                                                                                            cmbPeriodo.getValue()+'","fechaLimite":"'+
                                                                                            (fechaPresentacionImputado.getValue()!=''?fechaPresentacionImputado.getValue().format('Y-m-d'):'')+
                                                                                            '","periodoLimite":"'+periodoPresentacionImputado.getValue()+
                                                                                            '","plazoPeriodoLimite":"'+cmbPeriodoPresentacion.getValue()+
                                                                                            '","audienciaConcede":"'+cmbAudiencia.getValue()+'"}';
                                                                        
																	
                                                                    	guardarDatosDocumento(cadObj,cadParametros,ventanaAM);
                                                                    
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

function crearGridRegistrosSCPAdolescente()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idCondicion'},
                                                                    {name: 'detallesAdicionales'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Condici&oacute;n',
															width:250,
															sortable:true,
															dataIndex:'idCondicion',
                                                            renderer:function(val,meta,registro)
                                                            				{
                                                                            	meta.attr='style="min-height:21px; height:auto; white-space: normal;"';
                                                                            	return formatearValorRenderer(arrCondicionesSCAdolescentesOTRO,val);
                                                                            }
														},
														{
															header:'Detalles adicionales',
															width:300,
															sortable:true,
															dataIndex:'detallesAdicionales',
                                                            renderer:function(val,meta,registro)
                                                            				{
                                                                            	meta.attr='style="min-height:21px; height:auto; white-space: normal;"';
                                                                            	return val;
                                                                            }
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:false,
                                                            x:10,
                                                            y:10,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            id:'gSuspencion',
                                                            columnLines : true,
                                                            height:290,
                                                            width:750,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar condición de suspensi&oacute;n condicional',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaAgregarCondicion();
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover condición de suspensi&oacute;n condicional',
                                                                            handler:function()
                                                                            		{
                                                                                    	var filas=tblGrid.getStore().getSelections();
                                                                                        if(filas.length==0)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar la condici&oacute;n que desea remover');
                                                                                            
                                                                                        	return;
                                                                                        }
                                                                                        
                                                                                        tblGrid.getStore().removeAll(filas);
                                                                                        
                                                                                        
                                                                                        
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;
}

function crearGridRegistrosSCPAdultos()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idCondicion'},
                                                                    {name: 'detallesAdicionales'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Condici&oacute;n',
															width:250,
															sortable:true,
															dataIndex:'idCondicion',
                                                            renderer:function(val,meta,registro)
                                                            				{
                                                                            	meta.attr='style="min-height:21px; height:auto; white-space: normal;"';
                                                                            	return formatearValorRenderer(arrCondicionesSCAdultosOTRO,val);
                                                                            }
														},
														{
															header:'Detalles adicionales',
															width:300,
															sortable:true,
															dataIndex:'detallesAdicionales',
                                                            renderer:function(val,meta,registro)
                                                            				{
                                                                            	meta.attr='style="min-height:21px; height:auto; white-space: normal;"';
                                                                            	return val;
                                                                            }
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:false,
                                                            x:10,
                                                            y:10,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            id:'gSuspencion',
                                                            columnLines : true,
                                                            height:290,
                                                            width:750,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar condición de suspensi&oacute;n condicional',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaAgregarCondicion();
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover condición de suspensi&oacute;n condicional',
                                                                            handler:function()
                                                                            		{
                                                                                    	var filas=tblGrid.getStore().getSelections();
                                                                                        if(filas.length==0)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar la condici&oacute;n que desea remover');
                                                                                            
                                                                                        	return;
                                                                                        }
                                                                                        
                                                                                        tblGrid.getStore().removeAll(filas);
                                                                                        
                                                                                        
                                                                                        
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;
}


function mostrarVentanaAgregarCondicion()
{
	var cmbCondicion=crearComboExt('cmbCondicion',arrCondicionesSCAdolescentesOTRO,120,5,350);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Condici&oacute;n:'
                                                        },
                                                        cmbCondicion,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Detalles adicionales:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            width:500,
                                                            height:60,
                                                            xtype:'textarea',
                                                            id:'txtDetalles'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar condici&oacute;n de suspensi&oacute;n condicional de proceso',
										width: 550,
										height:250,
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
																		var cmbCondicion=gEx('cmbCondicion');
                                                                        if(cmbCondicion.getValue()==='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbCondicion.focus();
                                                                            }
                                                                            msgConfirm('Debe selecciona la condici&oacute;n de suspensi&oacute;n condicional de proceso que desea agregar',resp);
                                                                            return;                                                                            
                                                                        }
                                                                        
                                                                        var reg=crearRegistro (
                                                                        							[
                                                                                                        {name: 'idCondicion'},
                                                                                                    	{name: 'detallesAdicionales'}
                                                                                                    ]
                                                                                              )
                                                                        
                                                                        var r=new reg(	
                                                                        				{
                                                                                        	idCondicion:cmbCondicion.getValue(),
                                                                                            detallesAdicionales: gEx('txtDetalles').getValue()
                                                                        				}
                                                                                      )                      
                                                                        gEx('gSuspencion').getStore().add(r);
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

function mostrarVentanaAgregarCondicionAdultos()
{
	var cmbCondicion=crearComboExt('cmbCondicion',arrCondicionesSCAdultosOTRO,120,5,350);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Condici&oacute;n:'
                                                        },
                                                        cmbCondicion,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Detalles adicionales:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            width:500,
                                                            height:60,
                                                            xtype:'textarea',
                                                            id:'txtDetalles'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar condici&oacute;n de suspensi&oacute;n condicional de proceso',
										width: 550,
										height:250,
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
																		var cmbCondicion=gEx('cmbCondicion');
                                                                        if(cmbCondicion.getValue()==='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbCondicion.focus();
                                                                            }
                                                                            msgConfirm('Debe selecciona la condici&oacute;n de suspensi&oacute;n condicional de proceso que desea agregar',resp);
                                                                            return;                                                                            
                                                                        }
                                                                        
                                                                        var reg=crearRegistro (
                                                                        							[
                                                                                                        {name: 'idCondicion'},
                                                                                                    	{name: 'detallesAdicionales'}
                                                                                                    ]
                                                                                              )
                                                                        
                                                                        var r=new reg(	
                                                                        				{
                                                                                        	idCondicion:cmbCondicion.getValue(),
                                                                                            detallesAdicionales: gEx('txtDetalles').getValue()
                                                                        				}
                                                                                      )                      
                                                                        gEx('gSuspencion').getStore().add(r);
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


function mostrarVentanaAgregarMedida()
{
	var cmbMedida=crearComboExt('cmbMedida',arrMedidasCautelaresAdolescentesOTRO,120,5,350);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Medida Cautelar:'
                                                        },
                                                        cmbMedida,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Detalles adicionales:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            width:500,
                                                            height:60,
                                                            xtype:'textarea',
                                                            id:'txtDetalles'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar medida cautelar',
										width: 550,
										height:250,
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
																		var cmbMedida=gEx('cmbMedida');
                                                                        if(cmbMedida.getValue()==='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbMedida.focus();
                                                                            }
                                                                            msgConfirm('Debe selecciona la medida cautelar que desea agregar',resp);
                                                                            return;                                                                            
                                                                        }
                                                                        
                                                                        var reg=crearRegistro (
                                                                        							[
                                                                                                        {name: 'idMedidaCautelar'},
                                                                                                    	{name: 'detallesAdicionales'}
                                                                                                    ]
                                                                                              )
                                                                        
                                                                        var r=new reg(	
                                                                        				{
                                                                                        	idMedidaCautelar:cmbMedida.getValue(),
                                                                                            detallesAdicionales: gEx('txtDetalles').getValue()
                                                                        				}
                                                                                      )                      
                                                                        gEx('gMedidaCautelar').getStore().add(r);
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

function mostrarVentanaAgregarMedidaAdultos()
{
	var cmbMedida=crearComboExt('cmbMedida',arrMedidasCautelaresAdultoOTRO,120,5,350);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Medida Cautelar:'
                                                        },
                                                        cmbMedida,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Detalles adicionales:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            width:500,
                                                            height:60,
                                                            xtype:'textarea',
                                                            id:'txtDetalles'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar medida cautelar',
										width: 550,
										height:250,
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
																		var cmbMedida=gEx('cmbMedida');
                                                                        if(cmbMedida.getValue()==='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbMedida.focus();
                                                                            }
                                                                            msgConfirm('Debe selecciona la medida cautelar que desea agregar',resp);
                                                                            return;                                                                            
                                                                        }
                                                                        
                                                                        var reg=crearRegistro (
                                                                        							[
                                                                                                        {name: 'idMedidaCautelar'},
                                                                                                    	{name: 'detallesAdicionales'}
                                                                                                    ]
                                                                                              )
                                                                        
                                                                        var r=new reg(	
                                                                        				{
                                                                                        	idMedidaCautelar:cmbMedida.getValue(),
                                                                                            detallesAdicionales: gEx('txtDetalles').getValue()
                                                                        				}
                                                                                      )                      
                                                                        gEx('gMedidaCautelar').getStore().add(r);
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

function mostrarInterfaceParametrosAudienciaInicialAdolescentes(cadObj,ventana)
{
	objGlobalInfoDocumento=eval('['+decodeURIComponent(cadObj)+']')[0];
	var idUsuarioSesion='<?php echo $_SESSION["idUsr"]?>';
	if(ventana)
		ventana.close();
	var cmbAudienciaCelebrar=crearComboExt('cmbAudienciaCelebrar',arrAudienciasCarpeta,160,95,400);
    var cmbMostrarVictima=crearComboExt('cmbMostrarVictima',arrMostrarVictima,180,125,400);
    cmbMostrarVictima.setValue('1');
    var cmbImputados=crearComboExt('cmbImputados',arrImputados,160,65,300,{multiSelect:true});
	if(cmbImputados.getStore().getCount()==1)
    {
    	var x=0;
    	cmbImputados.setValue(cmbImputados.getStore().getAt(x).data.id);
    }
    
    
    var cmbFirmante=crearComboExt('cmbFirmante',arrFirmantesUnidad,180,155,400);

    if(judNotificadores!='-1')
    {
    	cmbFirmante.setValue(judNotificadores);
    }
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'<b>No de oficio a asignar:</b>'
                                                        },
                                                        {
                                                        	x:160,
                                                            y:5,
                                                            xtype:'numberfield',
                                                            id:'txtNoOficioAsignar',
                                                            allowDecimals:false,
                                                            allowNegative:false,
                                                            width:100
                                                        },
                                            			{
                                                        	x:10,
                                                            y:40,
                                                            html:'<b>Carpeta Judicial:</b>'
                                                        },
                                                        {
                                                        	x:160,
                                                            y:40,
                                                            html:'<span style="color: #900"><b>'+carpetaAdministrativa+'</b></span>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'<b>Imputados:</b>'
                                                        },
                                                        cmbImputados,
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            html:'<b>Audiencia a celebrar:</b>'
                                                        },
                                                        cmbAudienciaCelebrar,
                                                        
                                                        {
                                                        	x:10,
                                                            y:130,
                                                            html:'<b>Mostrar v&iacute;ctimas como:</b>'
                                                        },
                                                        cmbMostrarVictima,
                                                        {
                                                        	x:10,
                                                            y:160,
                                                            html:'<b>Firmado por:</b>'
                                                        },
                                                        cmbFirmante
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Se informa sobreseimiento',
										width: 700,
										height:300,
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
                                                                	gEx('txtNoOficioAsignar').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var txtNoOficioAsignar=gEx('txtNoOficioAsignar');
                                                                        var imputados=cmbImputados.getValue();
                                                                        
                                                                        if(txtNoOficioAsignar.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	txtNoOficioAsignar.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el folio del oficio a asignar',resp1);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(imputados=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbImputados.focus();
                                                                            }
                                                                        	msgBox('Debe indicar almenos un imputado involucrado en el asunto',resp2);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(cmbAudienciaCelebrar.getValue()=='')
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	cmbAudienciaCelebrar.focus();
                                                                            }
                                                                        	msgBox('Debe indicar la audiencia a celebrar',resp3);
                                                                        	return;
                                                                        }
                                                                        
                                                                        
                                                                        
                                                                        if(cmbFirmante.getValue()=='')
                                                                        {
                                                                        	function resp6()
                                                                            {
                                                                            	cmbFirmante.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el nombre del firmante del oficio',resp6);
                                                                        	return;
                                                                        }

                                                                        var cadParametros='{"noOficioAsignar":"'+txtNoOficioAsignar.getValue()+'","carpetaJudicial":"'+
                                                                        					carpetaAdministrativa+'","idCarpeta":"'+idCarpeta+'","imputados":"'+imputados+
                                                                                            '","audienciaCelebrar":"'+cmbAudienciaCelebrar.getValue()+
                                                                                            '","mostrarVictimasComo":"'+
                                                                                            cmbMostrarVictima.getValue()+'","usuarioDestinatario":"'+cmbFirmante.getValue()+'"}';
                                                                        
																	
                                                                    	guardarDatosDocumento(cadObj,cadParametros,ventanaAM);
                                                                    
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

function mostrarInterfaceParametrosInformeRiezgoProcesal(cadObj,ventana)
{
	objGlobalInfoDocumento=eval('['+decodeURIComponent(cadObj)+']')[0];
	if(ventana)
		ventana.close();
	var cmbAudienciaCelebrar=crearComboExt('cmbAudienciaCelebrar',arrAudienciasCarpeta,160,95,400);
    var cmbMostrarVictima=crearComboExt('cmbMostrarVictima',arrMostrarVictima,160,155,400);
    cmbMostrarVictima.setValue('1');
    var cmbImputados=crearComboExt('cmbImputados',arrImputados,160,65,300,{multiSelect:true});
	if(cmbImputados.getStore().getCount()==1)
    {
    	var x=0;
    	cmbImputados.setValue(cmbImputados.getStore().getAt(x).data.id);
    }
    
    
    var cmbJuezFirmante=crearComboExt('cmbJuezFirmante',arrJueces,160,95,350);
    var cmbAudiencia=crearComboExt('cmbAudiencia',arrAudienciasCarpeta,310,125,400);
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'<b>No de oficio a asignar:</b>'
                                                        },
                                                        {
                                                        	x:160,
                                                            y:5,
                                                            xtype:'numberfield',
                                                            id:'txtNoOficioAsignar',
                                                            allowDecimals:false,
                                                            allowNegative:false,
                                                            width:100
                                                        },
                                            			{
                                                        	x:10,
                                                            y:40,
                                                            html:'<b>Carpeta Judicial:</b>'
                                                        },
                                                        {
                                                        	x:160,
                                                            y:40,
                                                            html:'<span style="color: #900"><b>'+carpetaAdministrativa+'</b></span>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'<b>Imputados:</b>'
                                                        },
                                                        cmbImputados,
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            html:'<b>Juez que ordena:</b>'
                                                        },
                                                        cmbJuezFirmante,
                                                        {
                                                        	x:10,
                                                            y:130,
                                                            html:'<b>Audiencia en la cual se impone la medida cautelar:</b>'
                                                        },
                                                        cmbAudiencia,
                                                        {
                                                        	x:10,
                                                            y:160,
                                                            html:'<b>Mostrar v&iacute;ctimas como:</b>'
                                                        },
                                                        cmbMostrarVictima,
                                                        {
                                                        	x:10,
                                                            y:190,
                                                            html:'<b>Fecha l&iacute;mite de entrega:</b>'
                                                        },
                                                        {
                                                        	x:160,
                                                            y:185,
                                                            xtype:'datefield',
                                                            id:'fechaEntrega'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Se solicita Informe de Riesgo Procesal',
										width: 750,
										height:300,
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
                                                                	gEx('txtNoOficioAsignar').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var txtNoOficioAsignar=gEx('txtNoOficioAsignar');
                                                                        var imputados=cmbImputados.getValue();
                                                                        
                                                                        if(txtNoOficioAsignar.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	txtNoOficioAsignar.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el folio del oficio a asignar',resp1);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(imputados=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbImputados.focus();
                                                                            }
                                                                        	msgBox('Debe indicar almenos un imputado involucrado en el asunto',resp2);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(cmbJuezFirmante.getValue()=='')
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	cmbJuezFirmante.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el juez que ordena',resp3);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(cmbAudiencia.getValue()=='')
                                                                        {
                                                                        	function resp200()
                                                                            {
                                                                            	gEx('tabRegistros').setActiveTab(0);
                                                                            	cmbAudiencia.focus();
                                                                            }
                                                                        	msgBox('Debe indicar la audiencia en la cual se impone la medida cautelar',resp200);
                                                                        	return;
                                                                        }
                                                                        
                                                                        var fechaEntrega=gEx('fechaEntrega');
                                                                        
                                                                        if(fechaEntrega.getValue()=='')
                                                                        {
                                                                        	function resp6()
                                                                            {
                                                                            	fechaEntrega.focus();
                                                                            }
                                                                        	msgBox('Debe indicar la fecha l&iacute;mite de entrega del informe',resp6);
                                                                        	return;
                                                                        }

                                                                        var cadParametros='{"noOficioAsignar":"'+txtNoOficioAsignar.getValue()+'","carpetaJudicial":"'+
                                                                        					carpetaAdministrativa+'","idCarpeta":"'+idCarpeta+'","imputados":"'+imputados+
                                                                                            '","juezOrdena":"'+cmbJuezFirmante.getValue()+
                                                                                            '","mostrarVictimasComo":"'+cmbMostrarVictima.getValue()+'","fechaLimite":"'+
                                                                                            fechaEntrega.getValue().format('Y-m-d')+'","audienciaConcede":"'+
                                                                                            cmbAudiencia.getValue()+'"}';
                                                                        
																	
                                                                    	guardarDatosDocumento(cadObj,cadParametros,ventanaAM);
                                                                    
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

function mostrarInterfaceParametrosSolicitudPeritoGenetica(cadObj,ventana)
{
	objGlobalInfoDocumento=eval('['+decodeURIComponent(cadObj)+']')[0];
	if(ventana)
		ventana.close();
	
    var cmbJuezFirmante=crearComboExt('cmbJuezFirmante',arrJueces,160,95,350);
    
    var cmbMostrarVictima=crearComboExt('cmbMostrarVictima',arrMostrarVictima,160,125,400);
    cmbMostrarVictima.setValue('1');
    var cmbImputados=crearComboExt('cmbImputados',arrImputados,160,65,300,{multiSelect:true});
	if(cmbImputados.getStore().getCount()==1)
    {
    	var x=0;
    	cmbImputados.setValue(cmbImputados.getStore().getAt(x).data.id);
    }
    
    

    var cmbParentezco=crearComboExt('cmbParentezco',arrParentezco,160,185,200);
    var cmbSiNoLengua=crearComboExt('cmbSiNoLengua',arrSiNo,250,215,120);
    cmbSiNoLengua.on('select',function(cmb,registro)
    						{
                            	if(registro.data.id=='1')
                                {
                                	gEx('txtLengua').show();
                                }
                                else
                                {
                                	gEx('txtLengua').hide();
                                }
                            }
    				)
   
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'<b>No de oficio a asignar:</b>'
                                                        },
                                                        {
                                                        	x:160,
                                                            y:5,
                                                            xtype:'numberfield',
                                                            id:'txtNoOficioAsignar',
                                                            allowDecimals:false,
                                                            allowNegative:false,
                                                            width:100
                                                        },
                                            			{
                                                        	x:10,
                                                            y:40,
                                                            html:'<b>Carpeta Judicial:</b>'
                                                        },
                                                        {
                                                        	x:160,
                                                            y:40,
                                                            html:'<span style="color: #900"><b>'+carpetaAdministrativa+'</b></span>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'<b>Imputados:</b>'
                                                        },
                                                        cmbImputados,
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            html:'<b>Juez que ordena:</b>'
                                                        },
                                                        cmbJuezFirmante,
                                                        {
                                                        	x:10,
                                                            y:130,
                                                            html:'<b>Mostrar v&iacute;ctimas como:</b>'
                                                        },
                                                        cmbMostrarVictima,
                                                        {
                                                        	x:10,
                                                            y:160,
                                                            html:'<b>Persona con la cual se determinar&aacute; relaci&oacute;n:</b>'
                                                        },
                                                        {
                                                        	xtype:'textfield',
                                                            width:300,
                                                            x:300,
                                                            y:155,
                                                            id:'txtPersonaComparacion'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:190,
                                                            html:'<b>Parentezco:</b>'
                                                        }
                                                        ,
                                                        cmbParentezco,
                                                        {
                                                        	x:10,
                                                            y:220,
                                                            html:'<b>¿El adolescente habla alguna lengua?:</b>'
                                                        },
                                                        cmbSiNoLengua,
                                                        {
                                                        	x:390,
                                                            y:215,
                                                            width:200,
                                                            hidden:true,
                                                            xtype:'textfield',
                                                            id:'txtLengua'
                                                            
                                                        }
                                                        
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: objGlobalInfoDocumento.tituloDocumento,
										width: 700,
										height:340,
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
                                                                	gEx('txtNoOficioAsignar').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var txtNoOficioAsignar=gEx('txtNoOficioAsignar');
                                                                        var imputados=cmbImputados.getValue();
                                                                        
                                                                        if(txtNoOficioAsignar.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	txtNoOficioAsignar.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el folio del oficio a asignar',resp1);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(imputados=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbImputados.focus();
                                                                            }
                                                                        	msgBox('Debe indicar almenos un imputado involucrado en el asunto',resp2);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(cmbJuezFirmante.getValue()=='')
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	cmbJuezFirmante.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el nombre del juez que ordena',resp3);
                                                                        	return;
                                                                        }
                                                                        var txtPersonaComparacion=gEx('txtPersonaComparacion');
                                                                        if(txtPersonaComparacion.getValue()=='')
                                                                        {
                                                                        	function resp4()
                                                                            {
                                                                            	txtPersonaComparacion.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el nombre de la persona con la cual se determinar&aacute; relaci&oacute;n',resp4);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(cmbParentezco.getValue()=='')
                                                                        {
                                                                        	function resp5()
                                                                            {
                                                                            	cmbParentezco.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el parentezco de la persona con la cual se determinar&aacute; relaci&oacute;n',resp5);
                                                                        	return;
                                                                        }
                                                                        
                                                                        
                                                                        if(cmbSiNoLengua.getValue()=='')
                                                                        {
                                                                        	function resp6()
                                                                            {
                                                                            	cmbSiNoLengua.focus();
                                                                            }
                                                                        	msgBox('Debe indicar si el adolescente habla alguna lengua',resp6);
                                                                        	return;
                                                                        }
                                                                        var txtLengua=gEx('txtLengua');
                                                                        if(cmbSiNoLengua.getValue()=='1')
                                                                        {
                                                                        	if(txtLengua.getValue()=='')
                                                                            {
                                                                                function resp7()
                                                                                {
                                                                                    txtLengua.focus();
                                                                                }
                                                                                msgBox('Debe indicar la lengua que habla el adolescente',resp7);
                                                                                return;
                                                                        	}
                                                                        }

                                                                        var cadParametros='{"noOficioAsignar":"'+txtNoOficioAsignar.getValue()+'","carpetaJudicial":"'+
                                                                        					carpetaAdministrativa+'","idCarpeta":"'+idCarpeta+'","imputados":"'+imputados+
                                                                                            '","mostrarVictimasComo":"'+cmbMostrarVictima.getValue()+'","usuarioDestinatario":"'+
                                                                                            cmbJuezFirmante.getValue()+'","personaComparacion":"'+cv(gEx('txtPersonaComparacion').getValue())+
                                                                                            '","parentezco":"'+cmbParentezco.getValue()+'","hablaLengua":"'+cmbSiNoLengua.getValue()+
                                                                                            '","lengua":"'+txtLengua.getValue()+'"}';
                                                                        
																	
                                                                    	guardarDatosDocumento(cadObj,cadParametros,ventanaAM);
                                                                    
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

function  mostrarInterfaceParametrosMCAdolescentes(cadObj,ventana)
{
	objGlobalInfoDocumento=eval('['+decodeURIComponent(cadObj)+']')[0];
	if(ventana)
		ventana.close();
	
    var cmbImputados=crearComboExt('cmbImputados',arrImputados,160,65,400,{multiSelect:false});
	if(cmbImputados.getStore().getCount()==1)
    {
    	var x=0;
    	cmbImputados.setValue(cmbImputados.getStore().getAt(x).data.id);
    }
    
    var cmbJuezFirmante=crearComboExt('cmbJuezFirmante',arrJueces,160,125,350);
   	var cmbAudiencia=crearComboExt('cmbAudiencia',arrAudienciasCarpeta,350,95,400);
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	xtype:'tabpanel',
                                                            region:'center',
                                                            id:'tabRegistros',
                                                            activeTab:0,
                                                            items:	[
                                                            			{
                                                                        	xtype:'panel',
                                                                            layout:'absolute',
                                                                            defaultType: 'label',
                                                                            title:'Datos Generales',
                                                                            items:	[
                                                                            			{
                                                                                            x:10,
                                                                                            y:10,
                                                                                            html:'<b>No de oficio a asignar:</b>'
                                                                                        },
                                                                                        {
                                                                                            x:160,
                                                                                            y:5,
                                                                                            xtype:'numberfield',
                                                                                            id:'txtNoOficioAsignar',
                                                                                            allowDecimals:false,
                                                                                            allowNegative:false,
                                                                                            width:100
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:40,
                                                                                            html:'<b>Carpeta Judicial:</b>'
                                                                                        },
                                                                                        {
                                                                                            x:160,
                                                                                            y:40,
                                                                                            html:'<span style="color: #900"><b>'+carpetaAdministrativa+'</b></span>'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:70,
                                                                                            html:'<b>Imputado:</b>'
                                                                                        },
                                                                                        cmbImputados,
                                                                                         {
                                                                                            x:10,
                                                                                            y:100,
                                                                                            html:'<b>Audiencia en la cual se imponen las medidas cautelares:</b>'
                                                                                        },
                                                                                        cmbAudiencia,
                                                                                        {
                                                                                            x:10,
                                                                                            y:130,
                                                                                            html:'<b>Juez informante:</b>'
                                                                                        },
                                                                                        cmbJuezFirmante
                                                                            		]
                                                                        },
                                                                        
                                                                        {
                                                                        	xtype:'panel',
                                                                            layout:'absolute',
                                                                            defaultType: 'label',
                                                                            title:'Medidas Cautelares',
                                                                            items:	[
                                                                            			{
                                                                                        	x:10,
                                                                                            y:10,
                                                                                            html:'Seleccione las condiciones de suspenci&oacute;n condicional de proceso que apliquen:'
                                                                                        },
                                                                                        crearGridRegistrosMCAdolescente()
                                                                                        
                                                                                        
                                                                            		]
                                                                        }
                                                            		]
                                                        }
                                            			
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Se informan medidas cautelares',
										width: 810,
										height:430,
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
                                                                	gEx('txtNoOficioAsignar').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var txtNoOficioAsignar=gEx('txtNoOficioAsignar');
                                                                        var imputados=cmbImputados.getValue();
                                                                        
                                                                        if(txtNoOficioAsignar.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	gEx('tabRegistros').setActiveTab(0);
                                                                            	txtNoOficioAsignar.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el folio del oficio a asignar',resp1);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(imputados=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	gEx('tabRegistros').setActiveTab(0);
                                                                            	cmbImputados.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el imputado involucrado en el asunto',resp2);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(cmbAudiencia.getValue()=='')
                                                                        {
                                                                        	function resp200()
                                                                            {
                                                                            	gEx('tabRegistros').setActiveTab(0);
                                                                            	cmbAudiencia.focus();
                                                                            }
                                                                        	msgBox('Debe indicar la audiencia en la cual se concede imponen las medidas cautelares',resp200);
                                                                        	return;
                                                                        }
                                                                       
                                                                        
                                                                        if(cmbJuezFirmante.getValue()=='')
                                                                        {
                                                                        	function resp6()
                                                                            {
                                                                            	gEx('tabRegistros').setActiveTab(0);
                                                                            	cmbJuezFirmante.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el juez firmante del documento',resp6);
                                                                        	return;
                                                                        }
                                                                        
                                                                        var listaMedidas='';
                                                                        
                                                                        var x;
                                                                        var fila;
                                                                        var o;
                                                                        for(x=0;x<gEx('gMedidaCautelar').getStore().getCount();x++)
                                                                        {
                                                                        	fila=gEx('gMedidaCautelar').getStore().getAt(x);
                                                                            o='{"idMedidaCautelar":"'+fila.data.idMedidaCautelar+'","detalles":"'+cv(fila.data.detallesAdicionales)+'"}';
                                                                            if(listaMedidas=='')
                                                                            	listaMedidas=o;
                                                                            else
                                                                            	listaMedidas+=','+o
                                                                        }
                                                                        
                                                                        
                                                                        if(listaMedidas=='')
                                                                        {
                                                                        	
                                                                        	function resp12()
                                                                            {
                                                                            	gEx('tabRegistros').setActiveTab(1);
                                                                            	
                                                                            }
                                                                        	msgBox('Debe indicar las medidas cautelares a informar',resp12);
                                                                        	return
                                                                        }
                                                                       
	
                                                                        var cadParametros='{"noOficioAsignar":"'+txtNoOficioAsignar.getValue()+'","carpetaJudicial":"'+
                                                                        					carpetaAdministrativa+'","idCarpeta":"'+idCarpeta+'","imputados":"'+imputados+
                                                                                            '","medidadCautelares":['+listaMedidas+'],"usuarioOrdeno":"'+
                                                                                            cmbJuezFirmante.getValue()+'","audienciaConcede":"'+cmbAudiencia.getValue()+'"}';
                                                                        
																	
                                                                    	guardarDatosDocumento(cadObj,cadParametros,ventanaAM);
                                                                    
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

function crearGridRegistrosMCAdultos()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idMedidaCautelar'},
                                                                    {name: 'detallesAdicionales'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Medida cautelar',
															width:250,
															sortable:true,
															dataIndex:'idMedidaCautelar',
                                                            renderer:function(val,meta,registro)
                                                            				{
                                                                            	meta.attr='style="min-height:21px; height:auto; white-space: normal;"';
                                                                            	return formatearValorRenderer(arrMedidasCautelaresAdultoOTRO,val);
                                                                            }
														},
														{
															header:'Detalles adicionales',
															width:300,
															sortable:true,
															dataIndex:'detallesAdicionales',
                                                            renderer:function(val,meta,registro)
                                                            				{
                                                                            	meta.attr='style="min-height:21px; height:auto; white-space: normal;"';
                                                                            	return val;
                                                                            }
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:false,
                                                            x:10,
                                                            y:10,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            id:'gMedidaCautelar',
                                                            columnLines : true,
                                                            height:290,
                                                            width:750,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar medida cautelar',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaAgregarMedidaAdultos();
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover medida cautelar',
                                                                            handler:function()
                                                                            		{
                                                                                    	var filas=tblGrid.getStore().getSelections();
                                                                                        if(filas.length==0)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar la medida cautelar que desea remover');
                                                                                            
                                                                                        	return;
                                                                                        }
                                                                                        
                                                                                        tblGrid.getStore().removeAll(filas);
                                                                                        
                                                                                        
                                                                                        
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;
}

function crearGridRegistrosMCAdolescente()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idMedidaCautelar'},
                                                                    {name: 'detallesAdicionales'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Medida cautelar',
															width:250,
															sortable:true,
															dataIndex:'idMedidaCautelar',
                                                            renderer:function(val,meta,registro)
                                                            				{
                                                                            	meta.attr='style="min-height:21px; height:auto; white-space: normal;"';
                                                                            	return formatearValorRenderer(arrMedidasCautelaresAdolescentesOTRO,val);
                                                                            }
														},
														{
															header:'Detalles adicionales',
															width:300,
															sortable:true,
															dataIndex:'detallesAdicionales',
                                                            renderer:function(val,meta,registro)
                                                            				{
                                                                            	meta.attr='style="min-height:21px; height:auto; white-space: normal;"';
                                                                            	return val;
                                                                            }
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:false,
                                                            x:10,
                                                            y:10,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            id:'gMedidaCautelar',
                                                            columnLines : true,
                                                            height:290,
                                                            width:750,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar medida cautelar',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaAgregarMedida();
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover medida cautelar',
                                                                            handler:function()
                                                                            		{
                                                                                    	var filas=tblGrid.getStore().getSelections();
                                                                                        if(filas.length==0)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar la medida cautelar que desea remover');
                                                                                            
                                                                                        	return;
                                                                                        }
                                                                                        
                                                                                        tblGrid.getStore().removeAll(filas);
                                                                                        
                                                                                        
                                                                                        
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;
}

function mostrarInterfaceParametrosSolicitudEdadBiologica(cadObj,ventana)
{
	objGlobalInfoDocumento=eval('['+decodeURIComponent(cadObj)+']')[0];
	if(ventana)
		ventana.close();
	
    var cmbJuezFirmante=crearComboExt('cmbJuezFirmante',arrJueces,160,95,350);
    
    var cmbMostrarVictima=crearComboExt('cmbMostrarVictima',arrMostrarVictima,160,125,400);
    cmbMostrarVictima.setValue('1');
    var cmbImputados=crearComboExt('cmbImputados',arrImputados,160,65,300,{multiSelect:true});
	if(cmbImputados.getStore().getCount()==1)
    {
    	var x=0;
    	cmbImputados.setValue(cmbImputados.getStore().getAt(x).data.id);
    }
    
    

    
    var cmbSiNoLengua=crearComboExt('cmbSiNoLengua',arrSiNo,250,185,120);
    cmbSiNoLengua.on('select',function(cmb,registro)
    						{
                            	if(registro.data.id=='1')
                                {
                                	gEx('txtLengua').show();
                                }
                                else
                                {
                                	gEx('txtLengua').hide();
                                }
                            }
    				)
   
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'<b>No de oficio a asignar:</b>'
                                                        },
                                                        {
                                                        	x:160,
                                                            y:5,
                                                            xtype:'numberfield',
                                                            id:'txtNoOficioAsignar',
                                                            allowDecimals:false,
                                                            allowNegative:false,
                                                            width:100
                                                        },
                                            			{
                                                        	x:10,
                                                            y:40,
                                                            html:'<b>Carpeta Judicial:</b>'
                                                        },
                                                        {
                                                        	x:160,
                                                            y:40,
                                                            html:'<span style="color: #900"><b>'+carpetaAdministrativa+'</b></span>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'<b>Imputados:</b>'
                                                        },
                                                        cmbImputados,
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            html:'<b>Juez que ordena:</b>'
                                                        },
                                                        cmbJuezFirmante,
                                                        {
                                                        	x:10,
                                                            y:130,
                                                            html:'<b>Mostrar v&iacute;ctimas como:</b>'
                                                        },
                                                        cmbMostrarVictima,
                                                        {
                                                        	x:10,
                                                            y:160,
                                                            html:'<b>Persona que representa al imputado:</b>'
                                                        },
                                                        {
                                                        	xtype:'textfield',
                                                            width:300,
                                                            x:270,
                                                            y:155,
                                                            id:'txtPersonaRepresentacion'
                                                        },
                                                        
                                                        {
                                                        	x:10,
                                                            y:190,
                                                            html:'<b>¿El adolescente habla alguna lengua?:</b>'
                                                        },
                                                        cmbSiNoLengua,
                                                        {
                                                        	x:390,
                                                            y:185,
                                                            hidden:true,
                                                            width:200,
                                                            xtype:'textfield',
                                                            id:'txtLengua'
                                                            
                                                        }
                                                        
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: objGlobalInfoDocumento.tituloDocumento,
										width: 700,
										height:340,
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
                                                                	gEx('txtNoOficioAsignar').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var txtNoOficioAsignar=gEx('txtNoOficioAsignar');
                                                                        var imputados=cmbImputados.getValue();
                                                                        
                                                                        if(txtNoOficioAsignar.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	txtNoOficioAsignar.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el folio del oficio a asignar',resp1);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(imputados=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbImputados.focus();
                                                                            }
                                                                        	msgBox('Debe indicar almenos un imputado involucrado en el asunto',resp2);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(cmbJuezFirmante.getValue()=='')
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	cmbJuezFirmante.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el nombre del juez que ordena',resp3);
                                                                        	return;
                                                                        }
                                                                        var txtPersonaRepresentacion=gEx('txtPersonaRepresentacion');
                                                                        if(txtPersonaRepresentacion.getValue()=='')
                                                                        {
                                                                        	function resp4()
                                                                            {
                                                                            	txtPersonaRepresentacion.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el nombre de la persona que representa al imputado',resp4);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(cmbSiNoLengua.getValue()=='')
                                                                        {
                                                                        	function resp6()
                                                                            {
                                                                            	cmbSiNoLengua.focus();
                                                                            }
                                                                        	msgBox('Debe indicar si el adolescente habla alguna lengua',resp6);
                                                                        	return;
                                                                        }
                                                                        var txtLengua=gEx('txtLengua');
                                                                        if(cmbSiNoLengua.getValue()=='1')
                                                                        {
                                                                        	if(txtLengua.getValue()=='')
                                                                            {
                                                                                function resp7()
                                                                                {
                                                                                    txtLengua.focus();
                                                                                }
                                                                                msgBox('Debe indicar la lengua que habla el adolescente',resp7);
                                                                                return;
                                                                        	}
                                                                        }

                                                                        var cadParametros='{"noOficioAsignar":"'+txtNoOficioAsignar.getValue()+'","carpetaJudicial":"'+
                                                                        					carpetaAdministrativa+'","idCarpeta":"'+idCarpeta+'","imputados":"'+imputados+
                                                                                            '","mostrarVictimasComo":"'+cmbMostrarVictima.getValue()+'","usuarioDestinatario":"'+
                                                                                            cmbJuezFirmante.getValue()+'","representanteImputado":"'+cv(gEx('txtPersonaRepresentacion').getValue())+
                                                                                            '","hablaLengua":"'+cmbSiNoLengua.getValue()+
                                                                                            '","lengua":"'+txtLengua.getValue()+'"}';
                                                                        
																	
                                                                    	guardarDatosDocumento(cadObj,cadParametros,ventanaAM);
                                                                    
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