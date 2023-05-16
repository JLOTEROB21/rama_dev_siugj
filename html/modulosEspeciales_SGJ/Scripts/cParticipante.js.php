<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT idTipoTelefono,tipoTelefono FROM 1006_tipoTelefono";
	$arrTelefonosCParticipante=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__378_tablaDinamica,nacionalidad FROM _378_tablaDinamica ORDER BY nacionalidad";
	$arrNacionalidades=$con->obtenerFilasArreglo($consulta);
	
	$listParteProcesal="";
	$consulta="SELECT id__5_tablaDinamica,
	if((SELECT nombreSingular FROM _5_aliasTiposFiguras WHERE idFigura=t.id__5_tablaDinamica AND materia='".$tipoMateria."') is null
			,nombreTipo,(SELECT nombreSingular FROM _5_aliasTiposFiguras WHERE idFigura=t.id__5_tablaDinamica AND materia='".$tipoMateria."')) as nombreTipo, naturalezaFigura,
			descripcion
			 FROM _5_tablaDinamica t order by nombreTipo";
	$arrTipoFigura=$con->obtenerFilasArreglo($consulta);
	
	$arrParteProcesal="";
	
	$res=$con->obtenerFilas($consulta);
	while($filaFigura=mysql_fetch_row($res))
	{
		$consulta="SELECT idDetalle,etiquetaDetalle FROM _5_gDetallesTipo WHERE idReferencia=".$filaFigura[0];
		$arrDetalles=$con->obtenerFilasArreglo($consulta);
		$consulta="SELECT idOpcion FROM _5_tiposFiguras WHERE idPadre=".$filaFigura[0];
		$listFiguras=$con->obtenerListaValores($consulta);
		
		
		$consulta="SELECT idOpcion,IF(idOpcion='1','Natural','Jurídica') FROM _5_chkTipoPersonaPermitido WHERE idPadre=".$filaFigura[0]." ORDER BY idOpcion";
		$arrTiposFiguras=$con->obtenerFilasArreglo($consulta);
		
		
		$consulta="SELECT ti.id__32_tablaDinamica,ti.tipoIdentificacion FROM _5_gridTiposIdentificacionPermitidos si,_32_tablaDinamica ti WHERE si.idReferencia=".$filaFigura[0]." AND  ti.id__32_tablaDinamica=si.tipoIdentificacion
					ORDER BY ti.tipoIdentificacion";
		$arrTiposIdentificacion=$con->obtenerFilasArreglo($consulta);
		
		$o="['".$filaFigura[0]."','".cv($filaFigura[1])."',".$arrDetalles.",'".$listFiguras."','".$filaFigura[2]."',".$arrTiposFiguras.",".$arrTiposIdentificacion.",'".cv($filaFigura[3])."']";
		if($arrParteProcesal=="")
			$arrParteProcesal=$o;
		else
			$arrParteProcesal.=",".$o;
	}
	
	$consulta="SELECT idGenero,genero FROM 1005_generoUsuario";
	$arrGeneroCP=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__31_tablaDinamica,estadoCivil FROM _31_tablaDinamica";
	$arrEstadoCivil=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__32_tablaDinamica,tipoIdentificacion,funcionValidacion,funcionAfterSelect,
				maxLongitud,caracteresPermitidos,indicaNacionalidadLocal,contieneFechaExpedicion,muestraTarjetaProfesional FROM _32_tablaDinamica 
				WHERE situacion=1 ORDER BY prioridad";
	$arrTipoIdentificacion=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT id__32_tablaDinamica,tipoIdentificacion,funcionValidacion,funcionAfterSelect,
				maxLongitud,caracteresPermitidos,indicaNacionalidadLocal,contieneFechaExpedicion,muestraTarjetaProfesional FROM _32_tablaDinamica 
				ORDER BY prioridad";
	$arrTipoIdentificacionConfiguracion=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT cveEstado,estado FROM 820_estados ORDER BY estado";
	$arrEstadosCParticipante=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT id__857_tablaDinamica,medidaCautelar FROM _857_tablaDinamica WHERE tipoMedida=5 ORDER BY id__857_tablaDinamica";
	$arrGrupoEtnico=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__857_tablaDinamica,medidaCautelar FROM _857_tablaDinamica WHERE tipoMedida=6 ORDER BY id__857_tablaDinamica";
	$arrDiscapacidad=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT idPais,nombre FROM 238_paises ORDER BY nombre";
	$arrPaises=$con->obtenerFilasArreglo($consulta);
?>
var conoceFechaExpedicion='0';
var tratamientoApoderado='0';
var tipoParticipanteActual=0;
var naturaleza='';
var arrTipoEntidad=[['1','P\xFAblica'],['2','Privada'],['3','Econom\xEDa mixta'],['4','No aplica']];
var arrTipoIdentificacionConfiguracion=<?php echo $arrTipoIdentificacionConfiguracion?>;
var cObjeto=null;
var ignorarBusquedaMail=false;
var arrPaises=<?php echo $arrPaises?>;
var arrGrupoEtnico=<?php echo $arrGrupoEtnico?>;
var arrDiscapacidad=<?php echo $arrDiscapacidad?>;
var esBusquedaPersona=false;
var resultadoBusquedaWS=false;
var idPersonaEncontrada=-1;
var listPartes='-1';
var ajuste=0;
var arrTelefonosCParticipante=<?php echo $arrTelefonosCParticipante?>;
var arrEstadosCParticipante=<?php echo $arrEstadosCParticipante?>;
var arrTipoIdentificacionCP=<?php echo $arrTipoIdentificacion ?>;
var arrEstadoCivilCP=<?php echo $arrEstadoCivil?>;
var arrGeneroCP=<?php echo $arrGeneroCP?>;
var arrParteProcesalCP=[<?php echo $arrParteProcesal ?>];
var arrNacionalidadesCP=<?php echo $arrNacionalidades?>;
var arrTipoPersona=[['1','Natural'],['2','Jur\xEDdica']];
if(typeof(arrParteProcesal)=='undefined')
{
	arrParteProcesal=arrParteProcesalCP;
}

function agregarParticipanteVentana(tipoParticipante,nombreTipo,objConf)
{
	tipoParticipanteActual=tipoParticipante;
	ignorarBusquedaMail=false;
	var posFila=existeValorMatriz(arrParteProcesal,tipoParticipante);
	naturaleza=arrParteProcesal[posFila][4];

	esBusquedaPersona=false;
    idPersonaEncontrada=-1;
	ajuste=0;
    
	conoceFechaExpedicion='0';
    tratamientoApoderado='0';
    switch(tipoParticipante)
    {
    	case 2:
        case 6:
        case 7:
        case 11:
        case 16:	
        	conoceFechaExpedicion='1';
        break;
    	case 5:
        case 17:
        	conoceFechaExpedicion='1';
        	tratamientoApoderado='1';
        break;
    }
    
	

	var nTipo='';
	
   
    var cmbFiguraJuridica=null;
    
	var cmbDetalle=crearComboExt('cmbDetalle',[],460,15,150);
   	cmbDetalle.hide();

	var cmbNacionalidad=null;
    
    
	var cmbGenero=null;
    
    var cmbIdentificacion=null;
                            
                            
	var cmbEstadoCParticipante=null;
    var cmbMunicipioCParticipante=null;                            
	var cmbGrupoEtnico=null;  
    var cmbDiscapacidad=null;  
    
    
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	xtype:'tabpanel',
                                                            
                                                            id:'tblPersona',
                                                            border:false,
                                                            cls:'tabPanelSIUGJ',
                                                            region:'center',
                                                            activeTab:1,
                                                            items:	[
                                                            			{
                                                                        	xtype:'panel',
                                                                            defaultType: 'label',
                                                                            layout:'absolute',
                                                                            baseCls: 'x-plain',
                                                                            title:'Datos generales',
                                                                            items:	[
                                                                            			{
                                                                                            x:10,
                                                                                            y:20,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Sujeto Procesal: <span style="color:#F00">*</span>'
                                                                                        },
                                                                                        {
                                                                                            x:200,
                                                                                            y:20,
                                                                                            cls:'SIUGJ_ControlEtiqueta',
                                                                                            html:formatearValorRenderer(arrTipoFigura,tipoParticipante+'')
                                                                                        },
                                                                                        {
                                                                                        	x:350,
                                                                                            y:15,
                                                                                            cls:'controlSIUGJ',
                                                                                            id:'lblDescripcionFiguraJuridica',
                                                                                            html:''
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:70,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Tipo de persona:'
                                                                                        },
                                                                                        {
                                                                                            x:200,
                                                                                            y:65,
                                                                                            html:'<div id="divTipoPersona"></div>'
                                                                                        },
                                                                                        {
                                                                                            x:610,
                                                                                            y:90,
                                                                                            id:'lblErrorCedula_1',
                                                                                            hidden:true,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'<span style="color:#F00">Tarjeta Profesional no existe</span>'//'<span style="color:#900">El n&uacute;mero de c&eacute;dula ingresada NO existe</span>'
                                                                                        },
                                                                                        {
                                                                                            x:610,
                                                                                            y:90,
                                                                                            id:'lblErrorCedula_2',
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            hidden:true,
                                                                                            html:'<span style="color:#F00">Tarjeta profesional No vigente</span>'
                                                                                        },
                                                                                         {
                                                                                            x:610,
                                                                                            y:90,
                                                                                            id:'lblErrorCedula_3',
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            hidden:true,
                                                                                            html:'<span style="color:#030">Tarjeta profesional vigente</span>'
                                                                                        },
                                                                                        {
                                                                                            x:610,
                                                                                            y:90,
                                                                                            id:'lblErrorCedula_4',
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            hidden:true,
                                                                                            html:'<span style="color:#F00">Tarjeta profesional sin validar</span>'
                                                                                        },
                                                                                        {
                                                                                            x:500,
                                                                                            y:140,
                                                                                            id:'lblErrorCedula_5',
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            hidden:true,
                                                                                            html:'<span style="color:#F00">No existe</span>'
                                                                                        },
                                                                                        {
                                                                                            x:500,
                                                                                            y:140,
                                                                                            id:'lblErrorCedula_6',
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            hidden:true,
                                                                                            html:'<span style="color:#F00">Error en servicio de consulta</span>'
                                                                                        },
                                                                                        {
                                                                                              x:10,
                                                                                              y:120,
                                                                                              hidden:true,
                                                                                              cls:'SIUGJ_Etiqueta',
                                                                                              id:'lblTipoEntidad',
                                                                                              html:'Tipo de Entidad: <span style="color:#F00">*</span>'
                                                                                          },
                                                                                          {
                                                                                              x:200,
                                                                                              y:115,
                                                                                              id:'divTipoEntidad',
                                                                                              hidden:true,
                                                                                              html:'<div id="divComboTipoEntidad" style="width:230px"></div>'
                                                                                          },
                                                                                        {
                                                                                            x:10,
                                                                                            y:120,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            id:'lblIdentificacion',
                                                                                            xtype:'label',
                                                                                            html:'Tipo de identificaci&oacute;n: <span style="color:#F00">*</span>'
                            
                                                                                            
                                                                                        },
                                                                                        {
                                                                                            x:230,
                                                                                            y:115,
                                                                                            id:'lblDivComboIdentificacion',
                                                                                            html:'<div id="divComboIdentificacion"></div>'
                                                                                        },
                                                                                        {
                                                                                                x:400,
                                                                                                y:200,
                                                                                                ctCls:'SIUGJ_Etiqueta',
                                                                                                id:'lblDesconoceNIT',
                                                                                                xtype:'checkbox',
                                                                                                hidden:true,
                                                                                                listeners:	{
                                                                                                				check:function(chk,valor)
                                                                                                                		{
                                                                                                                        	if(valor)
                                                                                                                            {
                                                                                                                            	gEx('txtNIT').setValue('');
                                                                                                                            	gEx('txtNIT').disable();
                                                                                                                                gEx('txtRazonSocial').enable();
                                                                                                                                gEx('lblErrorCedula_5').hide();
                                                                                                                                gEx('lblErrorCedula_6').hide();
                                                                    	
                                                                                                                                
                                                                                                                            }
                                                                                                                            else
                                                                                                                            {
                                                                                                                            	
                                                                                                                                gEx('txtNIT').enable();
                                                                                                                                gEx('txtNIT').focus();
                                                                                                                                gEx('txtRazonSocial').disable()
                                                                                                                            }
                                                                                                                        }
                                                                                                			},
                                                                                                boxLabel:'NO conozco el NIT / NO aplica'
                                
                                                                                                
                                                                                            },  
                                                                                        {
                                                                                        	x:400,
                                                                                            y:165,
                                                                                            hidden:true,
                                                                                            id:'txtNIT',
                                                                                            cls:'controlSIUGJ',
                                                                                            xtype:'textfield',
                                                                                            enableKeyEvents :true,
                                                                                            listeners:	{
                                                                                                            keypress:function(txt,e)
                                                                                                                {

                                                                                                                    if(e.charCode=='46')
                                                                                                                    {
                                                                                                                    	e.stopEvent();
                                                                                                                    	return;
                                                                                                                    }
                                                                                                                    if(e.charCode=='13')
                                                                                                                    {
                                                                                                                        if(txt.getValue()=='')
                                                                                                                            return;
                                                                                                                    	
                                                                                                                        if(validarNIT(txt.getValue(),1))
                                                                                                                        {   
                                                                                                                            if(txt.ultimaBusqueda!=txt.getValue())
                                                                                                                            {
                                                                                                                                txt.ultimaBusqueda=txt.getValue();
                                                                                                                                buscarPersona(txt.getValue(),14,tipoParticipante);
                                                                                                                            }
                                                                                                                        }
                                                                                                                    }
                                                                                                                    
                                                                                                                    var posDocumento=existeValorMatriz(arrTipoIdentificacionConfiguracion,'14');
                                                                                                                    var filaDocumento=arrTipoIdentificacionConfiguracion[posDocumento];
                                                                                                                    
                                                                                                                    if(filaDocumento[4]!='')
                                                                                                                    {
                                                                                                                    	if((txt.getValue().length+1)>parseInt(filaDocumento[4]))
                                                                                                                        {
                                                                                                                        	e.stopEvent();
                                                                                                                        }
                                                                                                                    }
                                                                                                                    if(filaDocumento[5]!='')
                                                                                                                    {
                                                                                                                    	var re =null;
                                                                                                                        
                                                                                                                        eval('re=/['+filaDocumento[5]+']/;');
                                                                                                                        var caracter=String.fromCharCode(e.charCode);
                                                                                                                        if(!re.test(caracter))
                                                                                                                        {
                                                                                                                        	e.stopEvent();
                                                                                                                        }
                                                                                                                        
                                                                                                                    }
                                                                                                                    
                                                                                                                    
                                                                                                                },
                                                                                                            blur:function(txt)
                                                                                                                {
                                                                                                                    if(txt.getValue()=='')
                                                                                                                        return;
                                                                                                                    if(validarNIT(txt.getValue(),1))
                                                                                                                    {  
                                                                                                                        if(txt.ultimaBusqueda!=txt.getValue())
                                                                                                                        {
                                                                                                                            txt.ultimaBusqueda=txt.getValue();
                                                                                                                            buscarPersona(txt.getValue(),'14',tipoParticipante);
                                                                                                                        }
                                                                                                                    }
                                                                                                                    
                                                                                                                }
                                                                                                        },
                                                                                            
                                                                                            width:200
                                                                                        },
                                                                                        {
                                                                                            x:50,
                                                                                            y:190,
                                                                                            cls:'controlSIUGJ',
                                                                                            id:'lblSinDigito',
                                                                                            hidden:true,
                                                                                            xtype:'label',
                                                                                            html:'(Ingrese el NIT sin d&iacute;gito verificador)'
                            
                                                                                            
                                                                                        },
                                                                                        {
                                                                                            x:575,
                                                                                            y:120,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            id:'lblNoIdentificacion',
                                                                                            xtype:'label',
                                                                                            html:'No. de Identificaci&oacute;n: <span style="color:#F00">*</span>'
                            
                                                                                            
                                                                                        },
                                                                                        {
                                                                                            xtype:'textfield',
                                                                                            x:770,
                                                                                            y:115,
                                                                                            cls:'controlSIUGJ',
                                                                                            id:'txtEspecifique',
                                                                                            width:170,
                                                                                            enableKeyEvents :true,
                                                                                            listeners:	{
                                                                                                            keypress:function(txt,e)
                                                                                                                {

                                                                                                                    if(e.charCode=='46')
                                                                                                                    {
                                                                                                                    	e.stopEvent();
                                                                                                                    	return;
                                                                                                                    }
                                                                                                                    if(e.charCode=='13')
                                                                                                                    {
                                                                                                                        if(txt.getValue()=='')
                                                                                                                            return;
                                                                                                                    	
                                                                                                                        if(validarNoIdentificacion(1))
                                                                                                                        {   
                                                                                                                            if(txt.ultimaBusqueda!=txt.getValue())
                                                                                                                            {
                                                                                                                                txt.ultimaBusqueda=txt.getValue();
                                                                                                                                buscarPersona(txt.getValue(),cmbIdentificacion.getValue(),tipoParticipante);
                                                                                                                            }
                                                                                                                        }
                                                                                                                    }
                                                                                                                    
                                                                                                                    var posDocumento=existeValorMatriz(arrTipoIdentificacionConfiguracion,gEx('cmbIdentificacion').getValue());
                                                                                                                    var filaDocumento=arrTipoIdentificacionConfiguracion[posDocumento];
                                                                                                                    
                                                                                                                    if(filaDocumento[4]!='')
                                                                                                                    {
                                                                                                                    	if((txt.getValue().length+1)>parseInt(filaDocumento[4]))
                                                                                                                        {
                                                                                                                        	e.stopEvent();
                                                                                                                        }
                                                                                                                    }
                                                                                                                    if(filaDocumento[5]!='')
                                                                                                                    {
                                                                                                                    	var re =null;
                                                                                                                        
                                                                                                                        eval('re=/['+filaDocumento[5]+']/;');
                                                                                                                        var caracter=String.fromCharCode(e.charCode);
                                                                                                                        if(!re.test(caracter))
                                                                                                                        {
                                                                                                                        	e.stopEvent();
                                                                                                                        }
                                                                                                                        
                                                                                                                    }
                                                                                                                    
                                                                                                                    
                                                                                                                },
                                                                                                            blur:function(txt)
                                                                                                                {
                                                                                                                    if(txt.getValue()=='')
                                                                                                                        return;
                                                                                                                    
                                                                                                                    if(validarNoIdentificacion(1))
                                                                                                                    {  
                                                                                                                        if(txt.ultimaBusqueda!=txt.getValue())
                                                                                                                        {
                                                                                                                            txt.ultimaBusqueda=txt.getValue();
                                                                                                                            buscarPersona(txt.getValue(),cmbIdentificacion.getValue(),tipoParticipante);
                                                                                                                        }
                                                                                                                    }
                                                                                                                    
                                                                                                                }
                                                                                                        }
                                                                                        },
                                                                                        {
                                                                                              x:230,
                                                                                              y:165,
                                                                                              cls:'SIUGJ_Etiqueta',
                                                                                              id:'lblSinIdentificacion',
                                                                                              xtype:'checkbox',
                                                                                              hidden:naturaleza!='D',
                                                                                              listeners:	{
                                                                                                              check:function(chk,valor)
                                                                                                                      {
                                                                                                                          if(valor)
                                                                                                                          {
                                                                                                                              gEx('lblTarjetaProfesional').hide();
                                                                                                                              gEx('txtTarjetaProfesional').hide();
                                                                                                                              gEx('lblNoIdentificacion').hide();
                                                                                                                              gEx('txtEspecifique').setValue('');
                                                                                                                              gEx('txtEspecifique').ultimaValidacion='';
                                                                                                                              gEx('txtEspecifique').ultimaBusqueda='';
                                                                                                                              gEx('txtEspecifique').hide();
                                                                                                                              gEx('cmbIdentificacion').setValue('');
                                                                                                                              gEx('cmbIdentificacion').disable();
                                                                                                                              
                                                                                                                              
                                                                                                                              gEx('lblFechaExpedicion').hide();
                                                                                                                              gEx('lblValFechaExpedicion').hide();
                                                                                                                              gEx('divFechaDocumento').hide();
                                                                      
                                                                                                                              
                                                                                                                          }
                                                                                                                          else
                                                                                                                          {
                                                                                                                              
                                                                                                                              gEx('cmbIdentificacion').enable();
                                                                                                                          }
                                                                                                                      }
                                                                                                          },
                                                                                              boxLabel:'<b>Declaro NO conocer dato alguno referente a la identificaci&oacute;n de la persona</b>'
                              
                                                                                              
                                                                                          },
                                                                                        
                                                                                        {
                                                                                              x:10,
                                                                                              y:200,
                                                                                              cls:'SIUGJ_Etiqueta',
                                                                                              id:'lblFechaExpedicion',
                                                                                              html:'Fecha de expedición del documento de identidad:'
                                                                                          },
                                                                                          
                                                                                           {
                                                                                              x:435,
                                                                                              y:200,
                                                                                              cls:'SIUGJ_Etiqueta',
                                                                                              id:'lblValFechaExpedicion',
                                                                                              hidden:conoceFechaExpedicion=='0',
                                                                                              html:'<span style="color:#F00">*</span>'
                                                                                          },
                                                                                          
                                                                                          
                                                                                          
                                                                                          
                                                                                          {
                                                                                              x:455,
                                                                                              y:195,
                                                                                              id:'divFechaDocumento',
                                                                                              html:'<div id="dteFechaDocumento" style="width:140px"></div>'
                                                                                          },
                                                                                          {
                                                                                              x:620,
                                                                                              y:200,
                                                                                              hidden:true,
                                                                                              cls:'SIUGJ_Etiqueta',
                                                                                              id:'lblTarjetaProfesional',
                                                                                              html:'Tarjeta profesional: <span style="color:#F00">*</span>'
                                                                                          },
                                                                                          {
                                                                                              xtype:'textfield',
                                                                                              width:140,
                                                                                              hidden:true,
                                                                                              disabled:true,
                                                                                              cls:'controlSIUGJ',
                                                                                              id:'txtTarjetaProfesional',
                                                                                              x:800,
                                                                                              y:195
                                                                                          },
                                                                                         {
                                                                                              x:10,
                                                                                              y:250,
                                                                                              cls:'SIUGJ_Etiqueta',
                                                                                              id:'lblNombre',
                                                                                              html:'Nombre: <span style="color:#F00">*</span>'
                                                                                          },
                                                                                          {
                                                                                              xtype:'textfield',
                                                                                              width:220,
                                                                                              cls:'controlSIUGJ',
                                                                                              id:'txtNombre',
                                                                                              enableKeyEvents:true,
                                                                                              maskRe:/^[A-Za-zÁÉÍÓÚáéíóú\s\u00f1\u00d1]$/,
                                                                                              listeners:	{
                                                                                                                keypress:function(txt,e)
                                                                                                                    {
                                                                                                                    	
    
                                                                                                                        if((e.charCode>='33')&&(e.charCode<='38')||(e.charCode=='40'))
                                                                                                                        {
                                                                                                                            e.stopEvent( );
                                                                                                                            return;
                                                                                                                        }
                                                                                                                        
                                                                                                                    }
                                                                                                               },
                                                                                              x:180,
                                                                                              y:245
                                                                                          },
                                                                                          {
                                                                                              x:10,
                                                                                              y:240,
                                                                                              hidden:true,
                                                                                              cls:'SIUGJ_Etiqueta',
                                                                                              id:'lblRazonSocial',
                                                                                              html:'Raz&oacute;n Social: <span style="color:#F00">*</span>'
                                                                                          },
                                                                                          {
                                                                                              xtype:'textfield',
                                                                                              width:740,
                                                                                              hidden:true,
                                                                                              cls:'controlSIUGJ',
                                                                                              id:'txtRazonSocial',
                                                                                              //disabled:true,
                                                                                              x:200,
                                                                                              y:235
                                                                                          },
                                                                                           
                                                                                          
                                                                                          {
                                                                                              x:455,
                                                                                              y:250,
                                                                                              cls:'SIUGJ_Etiqueta',
                                                                                              id:'lblApPaterno',
                                                                                              html:'Primer Apellido: <span style="color:#F00">*</span>'
                                                                                          },
                                                                                          {
                                                                                              xtype:'textfield',
                                                                                              width:220,
                                                                                              cls:'controlSIUGJ',
                                                                                              id:'txtApPaterno',
                                                                                              x:610,
                                                                                              y:245,
                                                                                              enableKeyEvents:true,
                                                                                              maskRe:/^[A-Za-zÁÉÍÓÚáéíóú\s\u00f1\u00d1]$/,
                                                                                              listeners:	{
                                                                                                                keypress:function(txt,e)
                                                                                                                    {
                                                                                                                    	
    
                                                                                                                        if((e.charCode>='33')&&(e.charCode<='38')||(e.charCode=='40'))
                                                                                                                        {
                                                                                                                            e.stopEvent( );
                                                                                                                            return;
                                                                                                                        }
                                                                                                                        
                                                                                                                    }
                                                                                                               }
                                                                                          },
                                                                                          {
                                                                                              x:10,
                                                                                              y:300,
                                                                                              cls:'SIUGJ_Etiqueta',
                                                                                              id:'lblApMaterno',
                                                                                              html:'Segundo Apellido:'
                                                                                          },
                                                                                          {
                                                                                              xtype:'textfield',
                                                                                              width:220,
                                                                                              cls:'controlSIUGJ',
                                                                                              id:'txtApMaterno',
                                                                                              x:180,
                                                                                              y:295,
                                                                                              enableKeyEvents:true,
                                                                                              maskRe:/^[A-Za-zÁÉÍÓÚáéíóú\s\u00f1\u00d1]$/,
                                                                                              listeners:	{
                                                                                                                keypress:function(txt,e)
                                                                                                                    {
                                                                                                                    	
    
                                                                                                                        if((e.charCode>='33')&&(e.charCode<='38')||(e.charCode=='40'))
                                                                                                                        {
                                                                                                                            e.stopEvent( );
                                                                                                                            return;
                                                                                                                        }
                                                                                                                        
                                                                                                                    }
                                                                                                               },
                                                                                          }
                                                                                              
                                                                                          
                                                                            		]
                                                                        },
                                                                        {
                                                                        	xtype:'panel',
                                                                            defaultType: 'label',
                                                                            layout:'absolute',
                                                                            baseCls: 'x-plain',
                                                                            title:'Sociodemogr&aacute;ficos',
                                                                            items:	[
                                                                            			
                                                                            			{
                                                                                            x:10,
                                                                                            y:20,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            id:'lblGenero',
                                                                                            html:'G&eacute;nero: <span style="color:#F00">*</span>'
                                                                                        },
                                                                                        {
                                                                                            x:150,
                                                                                            y:15,
                                                                                            html:'<div id="divComboGenero"></div>'
                                                                                        },
                                                                                        
                                                                                        {
                                                                                            x:370,
                                                                                            y:20,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            id:'lblFechaNac',
                                                                                            html:'Fecha de nacimiento:'
                                                                                        },
                                                                                        {
                                                                                            x:570,
                                                                                            y:15,
                                                                                            html:'<div id="divComboFecha" style="width:140px"></div>'
                                                                                            
                                                                                        },
                                                                                        {
                                                                                            x:740,
                                                                                            y:20,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            id:'lblEdad',
                                                                                            html:'Edad:'
                                                                                        },
                                                                                        {
                                                                                            xtype:'numberfield',
                                                                                            width:60,
                                                                                            x:810,
                                                                                            y:15,
                                                                                            cls:'controlSIUGJ',
                                                                                            id:'txtEdad'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:70,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            id:'lblGrupoEtnico',
                                                                                            html:'Grupo &Eacute;tnico:'
                                                                                        },
                                                                                        {
                                                                                            x:150,
                                                                                            y:65,
                                                                                            html:'<div id="divGrupoEtnico"></div>'
                                                                                            
                                                                                        },
                                                                                        
                                                                                        {
                                                                                            x:370,
                                                                                            y:70,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            id:'lblDiscapacidad',
                                                                                            html:'Discapacidad:'
                                                                                        },
                                                                                        {
                                                                                            x:570,
                                                                                            y:65,
                                                                                            html:'<div id="divDiscapacidad"></div>'
                                                                                            
                                                                                        }
                                                                                        
                                                                            		]
                                                                        },
                                                                        {
                                                                        	xtype:'panel',
                                                                            defaultType: 'label',
                                                                            layout:'absolute',
                                                                            baseCls: 'x-plain',
                                                                            title:'Datos de contacto',
                                                                            items:	[
                                                                            			
                                                                            
                                                                            				{
                                                                                                x:10,
                                                                                                y:10,
                                                                                                height:280,
                                                                                                border:false,
                                                                                                id:'panelContacto',
                                                                                                xtype:'tabpanel',
                                                                                                listeners:	{
                                                                                                                tabchange:function( panel, tab )
                                                                                                                            {
                                                                                                                            	/*gEx('lblAceptaNotificacion').hide();
                                                                                                                                gEx('aceptaNotificacion_1').hide();
                                                                                                                                gEx('aceptaNotificacion_0').hide();
                                                                                                                                gEx('lblCorreoLeyenda').hide();
                                                                                                                                if(tab.id=='gMailCParticipante')
                                                                                                                                {
                                                                                                                                	
                                                                                                                                	if(naturaleza=='A')
                                                                                                                                    {
                                                                                                                                    	gEx('lblAceptaNotificacion').show();
                                                                                                                                        gEx('aceptaNotificacion_1').show();
                                                                                                                                        gEx('aceptaNotificacion_0').show();
                                                                                                                                        gEx('lblCorreoLeyenda').show();
                                                                                                                                    }
                                                                                                                                }*/
                                                                                                                            }
                                                                                                            },
                                                                                                activeTab:0,
                                                                                                items:	[
                                                                                                            {
                                                                                                                title:'Datos de domicilio',
                                                                                                                layout:'absolute',
                                                                                                                xtype:'panel',
                                                                                                                defaultType: 'label',
                                                                                                                items:	[
                                                                                                                            {
                                                                                                                                x:10,
                                                                                                                                y:20,
                                                                                                                                cls:'SIUGJ_Etiqueta',
                                                                                                                                id:'lblDireccion',
                                                                                                                                html:'Direcci&oacute;n de residencia:'
                                                                                                                            },
                                                                                                                            {
                                                                                                                                x:210,
                                                                                                                                y:20,
                                                                                                                                cls:'SIUGJ_Etiqueta',
                                                                                                                                id:'lblValDireccion',
                                                                                                                                hidden:naturaleza!='A',
                                                                                                                                html:' <span style="color:#F00"> *</span>'
                                                                                                                            },
                                                                                                                            {
                                                                                                                                x:300,
                                                                                                                                y:15,
                                                                                                                                xtype:'textfield',
                                                                                                                                width:610,
                                                                                                                                cls:'controlSIUGJ',
                                                                                                                                id:'txtCalleCParticipante'
                                                                                                                            },
                                                                                                                            {
                                                                                                                                x:500,
                                                                                                                                y:60,
                                                                                                                                hidden:true,
                                                                                                                                html:'No. Ext:'
                                                                                                                            },
                                                                                                                            {
                                                                                                                                x:560,
                                                                                                                                y:55,
                                                                                                                                xtype:'textfield',
                                                                                                                                width:95,hidden:true,
                                                                                                                                id:'txtNoExtCParticipante'
                                                                                                                            },
                                                                                                                            {
                                                                                                                                x:10,
                                                                                                                                y:100,
                                                                                                                                hidden:true,
                                                                                                                                html:'No. Int:'
                                                                                                                            },
                                                                                                                            {
                                                                                                                                x:70,
                                                                                                                                y:95,
                                                                                                                                xtype:'textfield',
                                                                                                                                width:120,
                                                                                                                                hidden:true,
                                                                                                                                id:'txtNoIntCParticipante'
                                                                                                                            },
                                                                                                                            {
                                                                                                                                x:10,
                                                                                                                                y:100,
                                                                                                                                hidden:true,
                                                                                                                                html:'Barrio:'
                                                                                                                            },
                                                                                                                            {
                                                                                                                                x:105,
                                                                                                                                y:100,
                                                                                                                                xtype:'textfield',
                                                                                                                                width:160,
                                                                                                                                hidden:true,
                                                                                                                                id:'txtColoniaCParticipante'
                                                                                                                            },
                                                                                                                            {
                                                                                                                                x:10,
                                                                                                                                y:60,
                                                                                                                                hidden:true,
                                                                                                                                cls:'SIUGJ_Etiqueta',
                                                                                                                                html:'C&oacute;digo Postal:'
                                                                                                                            },
                                                                                                                            {
                                                                                                                                x:150,
                                                                                                                                y:55,
                                                                                                                                xtype:'textfield',
                                                                                                                                width:95,
                                                                                                                                hidden:true,
                                                                                                                                cls:'controlSIUGJ',
                                                                                                                                id:'txtCPCParticipante'
                                                                                                                            },
                                                                                                                            {
                                                                                                                                x:10,
                                                                                                                                y:60,
                                                                                                                                cls:'SIUGJ_Etiqueta',
                                                                                                                                html:'Departamento de residencia:'
                                                                                                                            },
                                                                                                                            {
                                                                                                                                x:255,
                                                                                                                                y:60,
                                                                                                                                cls:'SIUGJ_Etiqueta',
                                                                                                                                id:'lblValDepto',
                                                                                                                                hidden:naturaleza!='A',
                                                                                                                                html:'<span style="color:#F00"> *</span>'
                                                                                                                            },
                                                                                                                             {
                                                                                                                                x:300,
                                                                                                                                y:55,
                                                                                                                                html:'<div id="divComboDepartamento"></div>'
                                                                                                                            },
                                                                                                                            
                                                                                                                            
                                                                                                                            {
                                                                                                                                x:10,
                                                                                                                                y:110,
                                                                                                                                cls:'SIUGJ_Etiqueta',
                                                                                                                                html:'Ciudad/municipio de residencia:'
                                                                                                                            },
                                                                                                                            {
                                                                                                                                x:280,
                                                                                                                                y:110,
                                                                                                                                cls:'SIUGJ_Etiqueta',
                                                                                                                                id:'lblValCiudad',
                                                                                                                                hidden:naturaleza!='A',
                                                                                                                                html:' <span style="color:#F00"> *</span>'
                                                                                                                            },
                                                                                                                           {
                                                                                                                                x:300,
                                                                                                                                y:105,
                                                                                                                                html:'<div id="divComboCiudad"></div>'
                                                                                                                            },
                                                                                                                            {
                                                                                                                                x:10,
                                                                                                                                y:100,
                                                                                                                                hidden:true,
                                                                                                                                html:'Localidad:'
                                                                                                                            },
                                                                                                                            {
                                                                                                                                x:105,
                                                                                                                                y:95,
                                                                                                                                xtype:'textfield',
                                                                                                                                width:230,
                                                                                                                                 hidden:true,
                                                                                                                                id:'txtLocalidadCParticipante'
                                                                                                                            },
                                                                                                                            {
                                                                                                                                x:10,
                                                                                                                                y:110,
                                                                                                                                hidden:true,
                                                                                                                                cls:'SIUGJ_Etiqueta',
                                                                                                                                html:'Entre la calle:'
                                                                                                                            },
                                                                                                                            {
                                                                                                                                x:150,
                                                                                                                                y:105,
                                                                                                                                xtype:'textfield',
                                                                                                                                width:230,
                                                                                                                                hidden:true,
                                                                                                                                cls:'controlSIUGJ',
                                                                                                                                id:'txtEntreCalleCParticipante'
                                                                                                                            },
                                                                                                                            {
                                                                                                                                x:410,
                                                                                                                                y:110,
                                                                                                                                hidden:true,
                                                                                                                                cls:'SIUGJ_Etiqueta',
                                                                                                                                html:'y la calle:'
                                                                                                                            },
                                                                                                                            {
                                                                                                                                x:510,
                                                                                                                                y:105,
                                                                                                                                xtype:'textfield',
                                                                                                                                width:230,
                                                                                                                                hidden:true,
                                                                                                                                cls:'controlSIUGJ',
                                                                                                                                id:'txtYCalleCParticipante'
                                                                                                                            },
                                                                                                                            {
                                                                                                                                x:10,
                                                                                                                                y:150,
                                                                                                                                hidden:true,
                                                                                                                                cls:'SIUGJ_Etiqueta',
                                                                                                                                html:'Otra referencia:'
                                                                                                                            },
                                                                                                                            {
                                                                                                                                x:150,
                                                                                                                                y:145,
                                                                                                                                xtype:'textarea',
                                                                                                                                width:530,
                                                                                                                                cls:'controlSIUGJ',
                                                                                                                                height:35,      
                                                                                                                                hidden:true,                                                                                      
                                                                                                                                id:'txtReferenciasCParticipante'
                                                                                                                            }
                                                                                                                        ]
                                                                                                            },	
                                                                                                            {
                                                                                                            	xtype:'panel',
                                                                                                                title:'Tel&eacute;fonos de contacto',
                                                                                                                layout:'border',
                                                                                                                items:	[
                                                                                                                			crearGridTelefonoCParticipante()
                                                                                                                		]
                                                                                                            }
                                                                                                            ,
                                                                                                            {
                                                                                                            	xtype:'panel',
                                                                                                                title:'Correos electr&oacute;nicos de contacto',
                                                                                                                layout:'border',
                                                                                                                items:	[
                                                                                                                			crearGridMailCParticipante()
                                                                                                                		]
                                                                                                            }
                                                                                                            
                                                                                                        ]
                                                                                            },
                                                                                            {
                                                                                                x:10,
                                                                                                y:300,
                                                                                                cls:'SIUGJ_Etiqueta',
                                                                                                id:'lblAceptaNotificacion',
                                                                                                xtype:'label',
                                                                                                hidden:naturaleza!='A',
                                                                                                html:'¿Acepta la Notificaci&oacute;n por Correo Electr&oacute;nico?: <span style="color:#F00">*</span>'
                                
                                                                                                
                                                                                            },  
                                                                                            
                                                                                            {
                                                                                                x:40,
                                                                                                y:300,
                                                                                                cls:'SIUGJ_Etiqueta',
                                                                                                id:'lblDesconoceDatoContacto',
                                                                                                xtype:'checkbox',
                                                                                                hidden:naturaleza!='D',
                                                                                                listeners:	{
                                                                                                				check:function(chk,valor)
                                                                                                                		{
                                                                                                                        	if(valor)
                                                                                                                            {
                                                                                                                            	gEx('txtCalleCParticipante').setValue('');
                                                                                                                                
                                                                                                                                gEx('cmbEstadoCParticipante').setValue('');
                                                                    															gEx('cmbMunicipioCParticipante').setValue('');
                                                                                                                                gEx('gTelefonosCParticipante').getStore().removeAll();
                                                                                                                                gEx('gMailCParticipante').getStore().removeAll();

                                                                                                                                gEx('panelContacto').setActiveTab(0);
                                                                                                                                gEx('panelContacto').disable();
                                                                    	
                                                                                                                                
                                                                                                                            }
                                                                                                                            else
                                                                                                                            {
                                                                                                                            	
                                                                                                                            	gEx('panelContacto').enable();
                                                                                                                            }
                                                                                                                        }
                                                                                                			},
                                                                                                boxLabel:'<b>Declaro NO conocer los datos de contacto, por lo cual solicito se emplace a la persona</b>'
                                
                                                                                                
                                                                                            },                                                                                              
                                                                                             {
                                                                                                  xtype:'radio',
                                                                                                  checked:true,
                                                                                                  name:'aceptaNotificacion',
                                                                                                  ctCls:'controlSIUGJ',
                                                                                                  id: 'aceptaNotificacion_1',
                                                                                                  inputValue: 1,
                                                                                                  x:430,
                                                                                                  y:295,      
                                                                                                  hidden:naturaleza!='A',                                                                                    
                                                                                                  boxLabel: 'S&iacute;'
                                                                                              }, 
                                                                                              {	
                                                                                                  xtype:'radio',
                                                                                                  name:'aceptaNotificacion',
                                                                                                  ctCls:'controlSIUGJ',
                                                                                                  id: 'aceptaNotificacion_0',
                                                                                                  inputValue: 0,
                                                                                                  x:530,
                                                                                                  y:295,
                                                                                                  hidden:naturaleza!='A',
                                                                                                  boxLabel: 'No'
                                                                                              }, 
                                                                                                {
                                                                                                    x:250,
                                                                                                    y:320,
                                                                                                    id:'lblCorreoLeyenda',
                                                                                                    xtype:'label',
                                                                                                    cls:'SIUGJ_Etiqueta',
                                                                                                    hidden:naturaleza!='A',
                                                                                                    html:'<span style="font-size:12px"><span style="color:#F00">*</span> Al aceptar, implica recibir la informaci&oacute;n por correo electr&oacute;nico y realizar las actuaciones en la plataformas SIUGJ</span>'
                                    
                                                                                                    
                                                                                                }
                                                                                        
                                                                                    	
                                                                            			]
                                                                        },
                                                                        {
                                                                        	xtype:'panel',
                                                                            defaultType: 'label',
                                                                            layout:'border',
                                                                            baseCls: 'x-plain',
                                                                            id:'tabRelacionado',
                                                                            title:'Relacionado con',
                                                                            items:	[
                                                                            			crearArbolSujetosProcesalesRelacion((objConf && objConf.idActividad)?objConf.idActividad:-1,(objConf && objConf.idParticipante)?objConf.idParticipante:-1,tipoParticipante+'')
                                                                            		]
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                        
                                            			
                                                        
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
                                    	id:'vParticipante',
										title: 'Agregar Sujeto Procesal',
										width: 980,
										height:500,
										layout: 'fit',
										plain:true,
										modal:true,
                                        cls:'msgHistorialSIUGJ',
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	gEx('tblPersona').setActiveTab(0);
                                                                    
                                                                    
                                                                    var pos=existeValorMatriz(arrParteProcesalCP,tipoParticipante+'');
                                                                    var filaFiguraJuridicaConf=arrParteProcesalCP[pos];
                                                                    
                                                                    
                                                                    gEx('lblDescripcionFiguraJuridica').setText(filaFiguraJuridicaConf[7]==''?'':'(<span style="color:#F00">*</span>'+filaFiguraJuridicaConf[7]+')',false);
                                                                    
                                                                    new Ext.form.DateField	(
                                                                                                {
                                                                                                    renderTo:'dteFechaDocumento',
                                                                                                    width:130,
                                                                                                    id:'fechaIdentificacion',
                                                                                                    maxValue:'<?php echo date("Y-m-d")?>',
                                                                                                    ctCls:'campoFechaSIUGJ'
                                                                                                }
                                                                                            )
                                                                    
                                                                    cmbTipoPersona=crearComboExt('cmbTipoPersona',filaFiguraJuridicaConf[5],0,0,180,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divTipoPersona'});
                                                                    
                                                                    
                                                                    cmbTipoPersona.setValue(filaFiguraJuridicaConf[5][0][0]);
                                                                    if(filaFiguraJuridicaConf[5].length==1)
                                                                    {
                                                                    	cmbTipoPersona.disable();
                                                                    }
                                                                    
                                                                	cmbTipoPersona.on('select',function(cmb,registro)
                                                                    							{
                                                                                                	tipoPersonaComboCP(cmb,registro);
                                                                                                }
                                                                    				)
                                                                    
                                                                    
                                                                    cmbIdentificacion=crearComboExt('cmbIdentificacion',filaFiguraJuridicaConf[6],0,0,310,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboIdentificacion'});
                                                                    cmbIdentificacion.on('select',function(cmb,registro)					
                                                                                                    {
                                                                                                    
                                                                                                    	var pos=existeValorMatriz(arrTipoIdentificacionConfiguracion,registro.data.id);
                                                                                                        
                                                                                                        var fila=arrTipoIdentificacionConfiguracion[pos];
                                                                                                        
                                                                                                        
                                                                                                        if(fila[7]=='1')
                                                                                                        {
                                                                                                        	gEx('lblFechaExpedicion').show();
                                                                                                            gEx('divFechaDocumento').show();
                                                                                                            
                                                                                                            
                                                                                                            if(conoceFechaExpedicion=='1')
                                                                                                            	gEx('lblValFechaExpedicion').show();
                                                                                                            else
                                                                                                            	gEx('lblValFechaExpedicion').hide();
                                                                                                            	
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                        	gEx('lblFechaExpedicion').hide();
                                                                                                            gEx('divFechaDocumento').hide();
                                                                                                            gEx('lblValFechaExpedicion').hide();	
                                                                                                        }
                                                                                                        
                                                                                                        if(tipoParticipante==5)
                                                                                                        {
                                                                                                            if(fila[8]=='1')
                                                                                                            {
                                                                                                                gEx('lblTarjetaProfesional').show();
                                                                                                                gEx('txtTarjetaProfesional').show();
                                                                                                            }
                                                                                                            else
                                                                                                            {
                                                                                                                gEx('lblTarjetaProfesional').hide();
                                                                                                                gEx('txtTarjetaProfesional').hide();
                                                                                                            }
                                                                                                        }
                                                                                                        
                                                                                                        
                                                                                                    
                                                                                                        gEx('txtEspecifique').setValue('');
                                                                                                        gEx('txtEspecifique').ultimaValidacion='';
                                                                                                        gEx('txtEspecifique').ultimaBusqueda='';
                                                                                                        
                                                                                                        if(fila[3]!='')
                                                                                                        {
                                                                                                        	eval(fila[3]+'('+registro.data.id+',registro);');
                                                                                                        }
                                                                                                        
                                                                                                    }
                                                                                            )
                                                                    
                                                                    
                                                                    if(filaFiguraJuridicaConf[6].length==1)
                                                                    {
                                                                    	cmbIdentificacion.setValue(filaFiguraJuridicaConf[6][0]);
                                                                    	cmbIdentificacion.disable();
                                                                    }
                                                                    
                                                                    cmbTipoEntidad=crearComboExt('cmbTipoEntidad',arrTipoEntidad,0,0,220,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboTipoEntidad'});
                                                                    cmbTipoEntidad.setValue('2');
                                                                    gEx('tblPersona').setActiveTab(1);
                                                                    
                                                                    cmbGenero=crearComboExt('cmbGenero',arrGeneroCP,0,0,180,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboGenero'});
                                                                    cmbGrupoEtnico=crearComboExt('cmbGrupoEtnico',arrGrupoEtnico,0,0,180,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divGrupoEtnico'});  
    																cmbDiscapacidad=crearComboExt('cmbDiscapacidad',arrDiscapacidad,0,0,250,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divDiscapacidad'});  
                                                                    new Ext.form.DateField	( {
                                                                              
                                                                                                  renderTo:'divComboFecha',
                                                                                                  width:130,
                                                                                                  ctCls:'campoFechaSIUGJ',
                                                                                                  xtype:'datefield',
                                                                                                  id:'fechaNacimiento',
                                                                                                  maxValue:'<?php echo date("Y-m-d")?>',
                                                                                                  listeners:	{
                                                                                                                  change:function(dte)
                                                                                                                          {
                                                                                                                              var edad=calcularEdadParticipante(dte.getValue());
                                                                                                                              gEx('txtEdad').setValue(edad);
                                                                                                                          }
                                                                                                              }
                                                                                              }
                                                                                             )
                                                                     
                                                                    gEx('tblPersona').setActiveTab(2);
                                                                    
                                                                    cmbEstadoCParticipante=crearComboExt('cmbEstadoCParticipante',arrEstadosCParticipante,0,0,260,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboDepartamento'});
                                                                    cmbEstadoCParticipante.on('select',obtenerMunicipiosCParticipante);
                                                                    cmbMunicipioCParticipante=crearComboExt('cmbMunicipioCParticipante',[],0,0,260,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboCiudad'});         
                                                                    
                                                                    
                                                                    
                                                                   /*	if((tipoProceso=='6')&&(tipoParticipante=='7'))
                                                                    {

                                                                        gEx('lblDireccion').setText('Direcci&oacute;n del domicilio del accionante:',false);
                                                                        gEx('txtCalleCParticipante').setPosition(360,15);
                                                                        gEx('txtCalleCParticipante').setWidth(400);
                                                                    }
                                                                    else
                                                                    {
                                                                    	gEx('lblDireccion').setText('Direcci&oacute;n:',false);
                                                                        gEx('txtCalleCParticipante').setPosition(150,15);
                                                                        gEx('txtCalleCParticipante').setWidth(410);
                                                                    }*/
                                                                    
                                                                    gEx('tblPersona').setActiveTab(3);
                                                                    buscarPartesAsociar(tipoParticipante+'');
                                                                    
                                                                    if(!objConf || !objConf.idParticipante)
                                                                    {
                                                                    }
                                                                    else
                                                                    {
                                                                        
                                                                        obtenerDatosIdentificacionVentana(objConf.idParticipante,tipoParticipante,ventanaAM,objConf);	
                                                                    }
                                                                    gEx('tblPersona').setActiveTab(0);
                                                                    gEx('txtNombre').focus();
                                                                    
                                                                    dispararEventoSelectCombo('cmbIdentificacion');
                                                                    
																}
															}
												},
										buttons:	[
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
                                                        {
															
															text: '<?php echo $etj["lblBtnAceptar"]?>', 
                                                            cls:'btnSIUGJ',
                                                            width:140, 
                                                            id:'btnAceptarAddPersona',                                                          
															handler: function()
																	{

                                                                    	if((esBusquedaPersona)&&(idPersonaEncontrada!='-1'))
                                                                        {
                                                                        	
                                                                            function funcAjax()
                                                                            {
                                                                                var resp=peticion_http.responseText;
                                                                                arrResp=resp.split('|');
                                                                                if(arrResp[0]=='1')
                                                                                {
                                                                                    recargarGridParticipantes();
                                                                                    ventanaAM.close();
                                                                                }
                                                                                else
                                                                                {
                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                }
                                                                            }
                                                                            obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesModuloRegistroPartes.php',funcAjax, 'POST','funcion=3&iF='+tipoParticipante+'&iA='+objConf.idActividad+'&iP='+idPersonaEncontrada,true);
                                                                        	
                                                                        	return;
                                                                        }

                                                                    	var campoComp='';
                                                                        if(objConf && objConf.idParticipante)
                                                                        {
                                                                        	campoComp=',"idPersona":"'+objConf.idParticipante+'"';
                                                                        }
                                                                    	if(cmbDetalle.getStore().getCount()>0)
                                                                        {
                                                                        	if(cmbDetalle.getValue()=='')
                                                                            {
                                                                                function resp301()
                                                                                {
                                                                                	 gEx('tblPersona').setActiveTab(0);
                                                                                    cmbDetalle.focus();
                                                                                }
                                                                                msgBox('Debe indicar el "tipo" del participante a agregar',resp301);
                                                                                return;
                                                                            }
                                                                            
                                                                        }
                                                                    	var listaRelacion='';
                                                                        var arrNodos=obtenerNodoChecados(gEx('arbolSujetosRelacion').getRootNode());
                                                                        var x;
                                                                        for(x=0;x<arrNodos.length;x++)
                                                                        {
                                                                        	if(listaRelacion=='')
                                                                            {
                                                                            	listaRelacion=arrNodos[x].attributes.idPersona;
                                                                            }
                                                                            else
                                                                            {
                                                                            	listaRelacion+=','+arrNodos[x].attributes.idPersona;
                                                                            }
                                                                        }
                                                                    	var personaMoral=gEx('cmbTipoPersona').getValue()=='2';
                                                                        var tipoIdentificacion='';
                                                                        
                                                                        
                                                                        var tipoIdentificacion=gEx('cmbIdentificacion').getValue();
                                                                        var folioIdentificacion=gEx('txtEspecifique').getValue();
                                                                        
																		var cadObj='';
                                                                        if(personaMoral)
                                                                        {
                                                                        
                                                                        	if(!gEx('txtNIT').disabled)
                                                                            {
                                                                                if(!validarNIT(gEx('txtNIT').getValue(),'14'))
                                                                                {
                                                                                	
                                                                                    return false;
                                                                                }
                                                                                
                                                                                tipoIdentificacion=14;
                                                                                folioIdentificacion=gEx('txtNIT').getValue();
                                                                                
																			} 
                                                                            else
                                                                            {
                                                                            	tipoIdentificacion=13;
                                                                                folioIdentificacion='';
                                                                            }                   
                                                                                                                                    
                                                                        	if(gEx('txtRazonSocial').getValue()=='')
                                                                            {
                                                                                function resp30()
                                                                                {
                                                                                	 gEx('tblPersona').setActiveTab(0);
                                                                                    gEx('txtRazonSocial').focus();
                                                                                }
                                                                                msgBox('Debe indicar la raz&oacute;n social de la persona jur&iacute;dica',resp30);
                                                                                return;
                                                                            }
                                                                            
                                                                            var aceptaNotificacionMail='0';
                                                                            if(gEx('aceptaNotificacion_1').getValue())
                                                                            {
                                                                            	aceptaNotificacionMail='1';
                                                                            }
                                                                            
                                                                            var cmbTipoEntidad=gEx('cmbTipoEntidad');
                                                                            
                                                                            if(cmbTipoEntidad.getValue()=='')
                                                                            {
                                                                                function resp301()
                                                                                {
                                                                                	 gEx('tblPersona').setActiveTab(0);
                                                                                    gEx('cmbTipoEntidad').focus();
                                                                                }
                                                                                msgBox('Debe indicar el tipo de entidad de la persona jur&iacute;dica',resp301);
                                                                                return;
                                                                            }
                                                                            
                                                                            
                                                                           cadObj='{"resultadoBusquedaWS":"'+(resultadoBusquedaWS?1:0)+'","grupoEtnico":"'+cmbGrupoEtnico.getValue()+'","discapacidad":"'+cmbDiscapacidad.getValue()+
                                                                           			'","aceptaNotificacionMail":"'+aceptaNotificacionMail+'","rfc":"'+cv(gEx('txtNIT').getValue())+
                                                                                    '","datosContacto":@datosContacto,"detallePersona":"'+cmbDetalle.getValue()+
                                                                            		'","tipoPersona":"2","nombre":"'+cv(gEx('txtRazonSocial').getValue())+
                                                                                    '","apPaterno":"","apMaterno":"","genero":"2","otraNacionalidad":"","nacionalidadMexicana":"3",'+
                                                                                    '"nacionalidad":"","alias":[],"tipoFigura":"'+tipoParticipante+
                                                                                    '","curp":"","cedulaProfesional":"","fechaNacimiento":"'+
                                                                                    (gEx('fechaNacimiento').getValue()==''?'':gEx('fechaNacimiento').getValue().format('Y-m-d'))+
                                                                                    '","edad":"'+gEx('txtEdad').getValue()+'","estadoCivil":"","identificacionPresentada":"'+
                                                                                    tipoIdentificacion+'","otraIdentificacion":"'+cv(folioIdentificacion)+'","relacionadoCon":"'+listaRelacion+'"'+
                                                                                    ',"fechaIdentificacion":"","tarjetaProfesional":"","tipoEntidad":"'+cmbTipoEntidad.getValue()+
                                                                                    '","idActividad":"'+objConf.idActividad+'","idCarpeta":"'+objConf.idCarpeta+'","desconoceNIT":"'+(gEx('lblDesconoceNIT').getValue()?'1':'0')+
                                                                                    '","desconoceIdentificacion":"'+(gEx('lblSinIdentificacion').getValue()?'1':'0')+
                                                                                    '","desconoceDatosContacto":"'+(gEx('lblDesconoceDatoContacto').getValue()?'1':'0')+'"'+campoComp+'}';
                                                                        }
                                                                        else
                                                                        {
                                                                        	var cmbIdentificacion=gEx('cmbIdentificacion');
                                                                        
                                                                        	if( (!cmbIdentificacion.disabled) && (cmbIdentificacion.isVisible()) && (cmbIdentificacion.getValue()==''))
                                                                            {
                                                                                function resp350()
                                                                                {
                                                                                	gEx('tblPersona').setActiveTab(0);
                                                                                    cmbIdentificacion.focus();
                                                                                }
                                                                                msgBox('Debe indicar el tipo de identificaci&oacute;n',resp350);
                                                                                return;
                                                                                
                                                                                
                                                                                if(!validarNoIdentificacion(2))
                                                                                {
                                                                                    
                                                                                    return;
                                                                                }
                                                                                
                                                                                tipoIdentificacion=cmbIdentificacion.getValue();
                                                                                
                                                                            }
                                                                            else
                                                                            {
                                                                            	tipoIdentificacion=cmbIdentificacion.getValue();
                                                                                if((cmbIdentificacion.disabled || !cmbIdentificacion.isVisible()) &&(cmbIdentificacion.getValue()==''))
                                                                                	tipoIdentificacion='13';
                                                                                
                                                                                	
                                                                            }
                                                                        
                                                                            if(gEx('txtEspecifique').isVisible() && (!gEx('txtEspecifique').disabled) && gEx('txtEspecifique').getValue()=='')
                                                                            {
                                                                                function resp300()
                                                                                {
                                                                                	gEx('tblPersona').setActiveTab(0);
                                                                                    gEx('txtEspecifique').focus();
                                                                                }
                                                                                msgBox('Debe indicar el n&uacute;mero de identificaci&oacute;n',resp300);
                                                                                return;
                                                                            }
                                                                            
                                                                            
                                                                            if(gEx('txtTarjetaProfesional').isVisible() && (!gEx('txtTarjetaProfesional').disabled) && gEx('txtTarjetaProfesional').getValue()=='')
                                                                            {
                                                                                function resp3001()
                                                                                {
                                                                                	gEx('tblPersona').setActiveTab(0);
                                                                                    gEx('txtTarjetaProfesional').focus();
                                                                                }
                                                                                msgBox('Debe ingresar  el n&uacute;mero de tarjeta profesional',resp3001);
                                                                                return;
                                                                            }

                                                                            
                                                                            
                                                                            if((gEx('divFechaDocumento').isVisible()) && (!gEx('fechaIdentificacion').disabled) &&(gEx('fechaIdentificacion').getValue()=='') &&(gEx('lblValFechaExpedicion').isVisible()) )
                                                                            {
                                                                                function resp301()
                                                                                {
                                                                                	gEx('tblPersona').setActiveTab(0);
                                                                                    gEx('fechaIdentificacion').focus();
                                                                                }
                                                                                msgBox('Debe indicar la fecha de expedici&oacute;n del documento de identidad',resp301);
                                                                                return;
                                                                            }
                                                                            
                                                                           
                                                                            
                                                                            
                                                                            if(gEx('txtNombre').getValue()=='')
                                                                            {
                                                                                function resp3()
                                                                                {
                                                                                	gEx('tblPersona').setActiveTab(0);
                                                                                	gEx('txtNombre').focus();
                                                                                }
                                                                                msgBox('Debe indicar el nombre de la persona f&iacute;sica',resp3);
                                                                                return;
                                                                            }
                                                                            
                                                                            if(gEx('txtApPaterno').getValue()=='')
                                                                            {
                                                                                function resp3AP()
                                                                                {
                                                                               		gEx('tblPersona').setActiveTab(0);
                                                                                    gEx('txtApPaterno').focus();
                                                                                }
                                                                                msgBox('Debe indicar el primer apellido de la persona f&iacute;sica',resp3AP);
                                                                                return;
                                                                            }
                                                                            
                                                                            var cmbTipoEntidad=gEx('cmbTipoEntidad');
                                                                            
                                                                            var fechaIdentificacion=gEx('fechaIdentificacion').getValue()==''?'':gEx('fechaIdentificacion').getValue().format('Y-m-d');
                                                                            var tarjetaProfesional=gEx('txtTarjetaProfesional').getValue();
                                                                            
                                                                            
                                                                            if(gEx('cmbGenero').getValue()=='')
                                                                            {
                                                                                function resp4()
                                                                                {
                                                                                	gEx('tblPersona').setActiveTab(1);
                                                                                    gEx('cmbGenero').focus();
                                                                                }
                                                                                msgBox('Debe indicar el g&eacute;nero de la persona f&iacute;sica',resp4);
                                                                                return;
                                                                            }
                                                                            
                                                                            
                                                                            
                                                                            
                                                                            var fila;
                                                                            var gAlias=gEx('gAlias');
                                                                            var arrAlias='';
                                                                            var x=0;
                                                                            var o;
                                                                           
                                                                            var nacionalidadMexicana='';                                                                            

                                                                           
                                                                            
                                                                           
                                                                            var pos=existeValorMatriz(arrTipoIdentificacionConfiguracion,cmbIdentificacion.getValue());
                                                                            nacionalidadMexicana=2;
                                                                            if(cmbIdentificacion.getValue()!='')
                                                                            {
                                                                            	nacionalidadMexicana=arrTipoIdentificacionConfiguracion[pos][6];
                                                                            }
                                                                            
                                                                            var aceptaNotificacionMail='0';
                                                                            if(gEx('aceptaNotificacion_1').getValue())
                                                                            {
                                                                            	aceptaNotificacionMail='1';
                                                                            }
                                                                            
                                                                           
                                                                            
                                                                        	cadObj='{"resultadoBusquedaWS":"'+(resultadoBusquedaWS?1:0)+'","grupoEtnico":"'+cmbGrupoEtnico.getValue()+'","discapacidad":"'+cmbDiscapacidad.getValue()+
                                                                           			'","aceptaNotificacionMail":"'+aceptaNotificacionMail+'","rfc":"'+cv(gEx('txtNIT').getValue())+
                                                                                    '","datosContacto":@datosContacto,"tipoPersona":"1","nombre":"'+cv(gEx('txtNombre').getValue())+'","apPaterno":"'+cv(gEx('txtApPaterno').getValue())+
                                                                            		'","apMaterno":"'+cv(gEx('txtApMaterno').getValue())+'","nacionalidadMexicana":"'+nacionalidadMexicana+
                                                                                    '","nacionalidad":"'+nacionalidadMexicana+'","otraNacionalidad":"","genero":"'+gEx('cmbGenero').getValue()+'","alias":[],"detallePersona":"'+cmbDetalle.getValue()+
                                                                                    '","tipoFigura":"'+tipoParticipante+
                                                                                    '","curp":"","cedulaProfesional":"","fechaNacimiento":"'+
                                                                                    (gEx('fechaNacimiento').getValue()==''?'':gEx('fechaNacimiento').getValue().format('Y-m-d'))+
                                                                                    '","edad":"'+gEx('txtEdad').getValue()+'","estadoCivil":"","identificacionPresentada":"'+tipoIdentificacion+'","otraIdentificacion":"'+
                                                                                    cv(folioIdentificacion)+'","relacionadoCon":"'+listaRelacion+'"'+
                                                                                    ',"fechaIdentificacion":"'+fechaIdentificacion+'","tarjetaProfesional":"'+tarjetaProfesional+
                                                                                    '","tipoEntidad":"'+cmbTipoEntidad.getValue()+'","idActividad":"'+objConf.idActividad+'","idCarpeta":"'+
                                                                                    objConf.idCarpeta+'","desconoceNIT":"'+(gEx('lblDesconoceNIT').getValue()?'1':'0')+
                                                                                    '","desconoceIdentificacion":"'+(gEx('lblSinIdentificacion').getValue()?'1':'0')+
                                                                                    '","desconoceDatosContacto":"'+(gEx('lblDesconoceDatoContacto').getValue()?'1':'0')+'"'+campoComp+'}';
                                                                        
                                                                        
                                                                        	
                                                                        }
                                                                        
                                                                        
                                                                        
                                                                        
                                                                        var txtCalle=gEx('txtCalleCParticipante');
                                                                        var txtNoExt=gEx('txtNoExtCParticipante');
                                                                        var txtNoInt=gEx('txtNoIntCParticipante');
                                                                        var txtColonia=gEx('txtColoniaCParticipante');
                                                                        var txtCP=gEx('txtCPCParticipante');
                                                                        var txtLocalidad=gEx('txtLocalidadCParticipante');
                                                                        var txtEntreCalle=gEx('txtEntreCalleCParticipante');
                                                                        var txtYCalle=gEx('txtYCalleCParticipante');
                                                                        var txtReferencias=gEx('txtReferenciasCParticipante');
                                                                        var cmbEstado=gEx('cmbEstadoCParticipante');
                                                                        var cmbMunicipio=gEx('cmbMunicipioCParticipante');
                                                                        
                                                                        var arrTelefonos='';
                                                                        var arrMails='';
                                                                        
                                                                        var ingresaDomicilio=false;
                                                                        
                                                                        
                                                                        if((!gEx('lblDesconoceDatoContacto').getValue())||(naturaleza=='A'))
                                                                        {
                                                                        	
                                                                            
                                                                            totalDatosIngresados=0;
                                                                            if((gEx('lblValDireccion').isVisible()) && (!gEx('txtCalleCParticipante').disabled) &&(gEx('txtCalleCParticipante').getValue()==''))
                                                                            {
                                                                                function respDireccion1()
                                                                                {
                                                                                    gEx('tblPersona').setActiveTab(2);
                                                                                    gEx('panelContacto').setActiveTab(0);
                                                                                    gEx('txtCalleCParticipante').focus();
                                                                                }
                                                                                msgBox('Debe indicar la dirección de residencia',respDireccion1);
                                                                                return;
                                                                                
                                                                                
                                                                            }
                                                                            else
                                                                            {
                                                                            	if(gEx('txtCalleCParticipante').getValue()!='')
                                                                            		totalDatosIngresados++;
                                                                            }
                                                                            
                                                                            if((gEx('lblValDepto').isVisible()) &&  (cmbEstado.disabled) &&(cmbEstado.getValue()==''))
                                                                            {
                                                                                function respDireccion2()
                                                                                {
                                                                                    gEx('tblPersona').setActiveTab(2);
                                                                                    gEx('panelContacto').setActiveTab(0);
                                                                                    cmbEstado.focus();
                                                                                }
                                                                                msgBox('Debe indicar el departamento de residencia',respDireccion2);
                                                                                return;
                                                                                
                                                                                
                                                                            }
                                                                            else
                                                                            {
                                                                            	if(cmbEstado.getValue()!='')
                                                                            		totalDatosIngresados++;
                                                                            }
                                                                            
                                                                            if((gEx('lblValCiudad').isVisible())&& (cmbMunicipio.disabled) &&(cmbMunicipio.getValue()==''))
                                                                            {
                                                                                function respDireccion3()
                                                                                {
                                                                                    gEx('tblPersona').setActiveTab(2);
                                                                                    gEx('panelContacto').setActiveTab(0);
                                                                                    cmbMunicipio.focus();
                                                                                }
                                                                                msgBox('Debe indicar la ciudad/municipio de residencia',respDireccion3);
                                                                                return;
                                                                                
                                                                                
                                                                            }
                                                                            else
                                                                            {
                                                                            	if(cmbMunicipio.getValue()!='')
                                                                            		totalDatosIngresados++;
                                                                            }
                                                                            
                                                                            if(totalDatosIngresados>0)
	                                                                            ingresaDomicilio=true;
                                                                            
                                                                         
                                                                         }   
                                                                            
                                                                        
                                                                        var x;
                                                                        var fila;
                                                                        var o;
                                                                        for(x=0;x<gEx('gTelefonosCParticipante').getStore().getCount();x++)
                                                                        {
                                                                            fila=gEx('gTelefonosCParticipante').getStore().getAt(x);
                                                                            
                                                                            if(fila.data.pais=='')
                                                                            {
                                                                                function respTel2()
                                                                                {
                                                                                    gEx('panelContactoCParticipante').setActiveTab(2);
                                                                                    gEx('panelContacto').setActiveTab(1);
                                                                                    gEx('gTelefonosCParticipante').startEditing(x,2);
                                                                                }
                                                                                msgBox('Debe ingresar el pa&iacute;s al cual pertenece el n&uacute;mero telef&oacute;nico',respTel2);
                                                                                return;
                                                                            }
                                                                            
                                                                            if(fila.data.numero=='')
                                                                            {
                                                                                function respTel()
                                                                                {
                                                                                    gEx('panelContactoCParticipante').setActiveTab(2);
                                                                                    gEx('panelContacto').setActiveTab(1);
                                                                                    gEx('gTelefonosCParticipante').startEditing(x,3);
                                                                                }
                                                                                msgBox('Debe ingresar el n&uacute;mero telef&oacute;nico a agregar',respTel);
                                                                                return;
                                                                            }
                                                                            
                                                                            o='{"tipoTelefono":"'+fila.data.tipoTelefono+'","lada":"'+fila.data.lada+
                                                                                '","numero":"'+fila.data.numero+'","extension":"'+fila.data.extension+
                                                                                '","pais":"'+fila.data.pais+'"}';
                                                                            if(arrTelefonos=='')
                                                                                arrTelefonos=o;
                                                                            else
                                                                                arrTelefonos+=','+o;
                                                                        }
                                                                        
                                                                        /*if(arrTelefonos=='')
                                                                        {
                                                                            function respTelefono()
                                                                            {
                                                                                gEx('tblPersona').setActiveTab(2);
                                                                            }
                                                                            msgBox('Debe ingresar al menos un n&uacute;mero tel&oacute;nico de contacto',respTelefono);
                                                                            return;
                                                                        }*/
                                                                        
                                                                        for(x=0;x<gEx('gMailCParticipante').getStore().getCount();x++)
                                                                        {
                                                                       		fila=gEx('gMailCParticipante').getStore().getAt(x);
                                                                            
                                                                            if(fila.data.mail=='')
                                                                            {
                                                                                function resp101()
                                                                                {
                                                                                    gEx('tblPersona').setActiveTab(2);
                                                                                    gEx('panelContacto').setActiveTab(2);
                                                                                    gEx('gMailCParticipante').startEditing(x,1);
                                                                                }
                                                                                msgBox('Debe ingresar la direcci&oacute;n de correo electr&oacute;nico de contacto',resp101);
                                                                                return;
                                                                            }
                                                                            
                                                                            if(!validarCorreo(fila.data.mail))
                                                                            {
                                                                                function resp103()
                                                                                {
                                                                                    gEx('tblPersona').setActiveTab(2);
                                                                                    gEx('panelContacto').setActiveTab(2);
                                                                                    gEx('gMailCParticipante').startEditing(x,1);
                                                                                    
                                                                                }
                                                                                msgBox('La direcci&oacute;n de correo electr&oacute;nico de contacto ingresada NO es v&aacute;lida',resp103);
                                                                                return;
                                                                            }
                                                                            var o='{"mail":"'+fila.data.mail+'"}';
                                                                            if(arrMails=='')
                                                                            	arrMails=o;
                                                                            else
                                                                            	arrMails+=','+o;
                                                                        }
                                                                        
                                                                        if((!gEx('lblDesconoceDatoContacto').getValue())&&(naturaleza=='A'))
                                                                        {
                                                                        	if(arrMails=='')
                                                                            {
                                                                            	function resp104()
                                                                                {
                                                                                    gEx('tblPersona').setActiveTab(2);
                                                                                    gEx('panelContacto').setActiveTab(2);
                                                                                   
                                                                                    
                                                                                }
                                                                                msgBox('Debe ingresar al menos una direci&oacute;n de correo electr&oacute;nico de contacto',resp104);
                                                                                return;
                                                                            }
                                                                        }
                                                                        
                                                                        
                                                                        
                                                                        
                                                                        if((!gEx('lblDesconoceDatoContacto').getValue()) &&  (!ingresaDomicilio) && (arrMails==''))
                                                                        {
                                                                        	function resp105()
                                                                            {
                                                                                gEx('tblPersona').setActiveTab(2);
                                                                                gEx('panelContacto').setActiveTab(2);
                                                                               
                                                                                
                                                                            }
                                                                        	msgBox('Debe ingresar al menos los datos de domicilio, una direci&oacute;n de correo electr&oacute;nico de contacto o declarar que NO conocer los datos de contacto',resp105);
                                                                            return;
                                                                        }
                                                                        
                                                                        
                                                                        var cadObjAux='{"calle":"'+cv(txtCalle.getValue())+'","noExt":"'+cv(txtNoExt.getValue())+
                                                                                    '","noInt":"'+cv(txtNoInt.getValue())+'","colonia":"'+cv(txtColonia.getValue())+
                                                                                    '","cp":"'+cv(txtCP.getValue())+'","estado":"'+cmbEstado.getValue()+
                                                                                    '","municipio":"'+cmbMunicipio.getValue()+'","localidad":"'+cv(txtLocalidad.getValue())+
                                                                                    '","entreCalle":"'+cv(txtEntreCalle.getValue())+'","yCalle":"'+cv(txtYCalle.getValue())+
                                                                                    '","referencias":"'+cv(txtReferencias.getValue())+'","arrTelefonos":['+arrTelefonos+
                                                                                    '],"mail":['+arrMails+'],"idRegistro":"-1","idFormulario":"-47"}';
                                                                        
                                                                        cadObj=cadObj.replace('@datosContacto',cadObjAux);
                                                                       
                                                                       
                                                                       	var nFuncion='';
                                                                        if(objConf && objConf.idParticipante)
                                                                        {
                                                                        	nFuncion=32;
                                                                        }
                                                                        else
                                                                        {
                                                                            nFuncion=20;
                                                                        }
                                                                        
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                if(objConf && objConf.afterRegister)
                                                                                    objConf.afterRegister(arrResp[1],arrResp[2],tipoParticipante,arrResp[3]);
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax, 'POST','funcion='+nFuncion+'&cadObj='+cadObj,true);
                                                                        
																	}
                                                                    
                                                                    
                                                                    
														}
													]
									}
								);
                                
	ventanaAM.objConf=objConf;     
    ventanaAM.listPartes=listPartes;  
    ventanaAM.tipoParticipante=tipoParticipante;                         
    ventanaAM.show();	
    	
    
   
}


function buscarPartesAsociar(parteProcesal)
{
	
	listPartes='';

    pos=existeValorMatriz(arrParteProcesalCP,parteProcesal);
    
    var x;
    if(arrParteProcesalCP[pos][3]!='')
    {
        var aFiguras=arrParteProcesalCP[pos][3].split(',');
        for(x=0;x<aFiguras.length;x++)
        {
            if(listPartes=='')
                listPartes=aFiguras[x];
            else   
                listPartes+=','+aFiguras[x];
        }
    }
    if(listPartes=='')
    {
        listPartes='-1';
    }
    
   
    
    gEx('cmbDetalle').getStore().loadData(arrParteProcesalCP[pos][2]);
    if(gEx('cmbDetalle').getStore().getCount()==0)
        gEx('cmbDetalle').hide();
    else
        gEx('cmbDetalle').show();
    
    
}

function crearGridTelefonoCParticipante()
{
	var cmbTipoTelefonoCParticipante=crearComboExt('cmbTipoTelefonoCParticipante',arrTelefonosCParticipante,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
	var cmbPais=crearComboExt('cmbPais',arrPaises,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
	
    var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'tipoTelefono'},
                                                                    {name: 'pais'},
                                                                    {name: 'lada'},
                                                                    {name: 'numero'},
                                                                    {name: 'extension'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({width:40});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	
														chkRow,
														{
															header:'Tipo',
															width:90,
															sortable:true,
															dataIndex:'tipoTelefono',
                                                            editor:cmbTipoTelefonoCParticipante,
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrTelefonosCParticipante,val);
                                                                    }
														},
														{
															header:'Lada',
															width:45,
                                                            hidden:true,
															sortable:true,
															dataIndex:'lada',
                                                            editor:	{
                                                            			xtype:'textfield'
                                                            		}
														},
                                                        {
															header:'Pa&iacute;s',
															width:200,
                                                            editor:cmbPais,
                                                            sortable:true,
															dataIndex:'pais',
                                                            renderer:function(val)
                                                            		{
                                                                    	return mostrarValorDescripcion(formatearValorRenderer(arrPaises,val));
                                                                    }
														},
                                                        {
															header:'N&uacute;mero',
															width:280,
															sortable:true,
															dataIndex:'numero',
                                                            editor:	{
                                                            			xtype:'textfield',
                                                                        enableKeyEvents:true,
                                                                        maskRe:/^[0-9]$/,
                                                                        listeners:	{
                                                                        				keypress:function(ctrl,e)
                                                                                        		{
                                                                                                	if(ctrl.getValue().length==10)
                                                                                                    {
                                                                                                    	e.stopEvent();
                                                                                                    }
                                                                                                }
                                                                        			},
                                                                        cls:'controlSIUGJ'
                                                            		}
														},
                                                        {
															header:'Extensi&oacute;n',
															width:100,
															sortable:true,
															dataIndex:'extension',
                                                            editor:	{
                                                            			xtype:'numberfield',
                                                                        allowDecimals:false,
                                                                        cls:'controlSIUGJ',
                                                                        allowNegative:false
                                                            		}
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gTelefonosCParticipante',
                                                            store:alDatos,
                                                            frame:false,
                                                            border:true,
                                                            region:'center',
                                                            clicksToEdit:1,
                                                            cls:'gridSiugjPrincipal',
                                                            cm: cModelo,
                                                            loadMask:true,
                                                            stripeRows :false,                                                            
                                                            columnLines : false,                                                            
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar tel&eacute;fono',
                                                                            handler:function()
                                                                            		{
                                                                                    	var reg=crearRegistro	(
                                                                                        							[
                                                                                                                    	{name: 'tipoTelefono'},
                                                                                                                        {name: 'lada'},
                                                                                                                        {name: 'pais'},
                                                                                                                        {name: 'numero'},
                                                                                                                        {name: 'extension'}
                                                                                                                    ]
                                                                                        						)
                                                                                   		var r=new reg	(
                                                                                        					{
                                                                                                            	tipoTelefono:'1',
                                                                                                                lada:'',
                                                                                                                pais:'52',
                                                                                                                numero:'',
                                                                                                                extension:''
                                                                                                            }
                                                                                        				)
                                                                                   
                                                                                    	gEx('gTelefonosCParticipante').getStore().add(r);
                                                                                        gEx('gTelefonosCParticipante').startEditing(gEx('gTelefonosCParticipante').getStore().getCount()-1,1);
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover tel&eacute;fono',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=gEx('gTelefonosCParticipante').getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el tel&eacute;fono a remover');
                                                                                        	return;
                                                                                        }
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	gEx('gTelefonosCParticipante').getStore().remove(fila);
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el tel&eacute;fono seleccionado?',resp);
                                                                                       
                                                                                        
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );

	tblGrid.on('afteredit',function(e)
    						{
                            	e.record.set(e.field,(e.value+'').replace("'",""));
                            }
    		)

	return 	tblGrid;	
}

function crearGridMailCParticipante()
{
	
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'mail'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({width:40});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	chkRow,
                                                        {
															header:'Correo electr&oacute;nico',
															width:500,
															sortable:true,
															dataIndex:'mail',
                                                            editor:	{
                                                            			xtype:'textfield',
                                                                        cls:'controlSIUGJ'
                                                            		}
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gMailCParticipante',
                                                            store:alDatos,
                                                            frame:false,
                                                            border:true,
                                                            region:'center',
                                                            cm: cModelo,
                                                            
                                                            cls:'gridSiugjPrincipal',
                                                            stripeRows :false,
                                                            loadMask:true,
                                                            columnLines : false,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar correo electr&oacute;nico',
                                                                            handler:function()
                                                                            		{
                                                                                    	var reg=crearRegistro	(
                                                                                        							[
                                                                                                                    	{name: 'mail'}
                                                                                                                    ]
                                                                                        						)
                                                                                   		var r=new reg	(
                                                                                        					{
                                                                                                            	mail:''
                                                                                                            }
                                                                                        				)
                                                                                   
                                                                                    	gEx('gMailCParticipante').getStore().add(r);
                                                                                        gEx('gMailCParticipante').startEditing(gEx('gMailCParticipante').getStore().getCount()-1,1);
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover correo electr&oacute;nico',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=gEx('gMailCParticipante').getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar la direcci&oacute;n de correo electr&oacute;nico a remover');
                                                                                        	return;
                                                                                        }
                                                                                        
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	gEx('gMailCParticipante').getStore().remove(fila);
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('¿Est&aacute; seguro de querer remover el correo electr&oacute;nico seleccionado?',resp);
                                                                                       
                                                                                        
                                                                                    }
                                                                            
                                                                        },
                                                                        {
                                                                        	xtype:'label',
                                                                            id:'lblNoCorreo',
                                                                            html:'<div id="lblNoCorreo" class="SIUGJ_Etiqueta" style="color:#F00 !important;"></div>'

                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;	
}

function crearGridAliasCP()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'nombre'},
                                                                    {name: 'apPaterno'},
                                                                    {name: 'apMaterno'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	chkRow,
														{
															header:'Nombre',
															width:220,
															sortable:true,
                                                            editor:	{xtype:'textfield'},
															dataIndex:'nombre'
														},
														{
															header:'Ap. Paterno',
															width:130,
															sortable:true,
                                                            editor:	{xtype:'textfield'},
															dataIndex:'apPaterno'
														},
														{
															header:'Ap. Materno',
															width:130,
															sortable:true,
                                                            editor:	{xtype:'textfield'},
															dataIndex:'apMaterno'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                        	id:'gAlias',
                                                            store:alDatos,
                                                            frame:false,
                                                            title:'Registro de alias',
                                                            x:10,
                                                            y:190,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,                                                            
                                                            columnLines : true,
                                                            height:150,
                                                            width:680,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar alias',
                                                                            handler:function()
                                                                            		{
                                                                                    	var reg=crearRegistro(	[
                                                                                        							{name: 'nombre'},
                                                                                                                    {name: 'apPaterno'},
                                                                                                                    {name: 'apMaterno'}
                                                                                        						]);
                                                                                    
                                                                                    	var r=new reg	(
                                                                                        					{
                                                                                                                nombre:'',
                                                                                                                apPaterno:'',
                                                                                                                apMaterno:''
                                                                                                            }
                                                                                        				)
                                                                                    
                                                                                    	gEx('gAlias').getStore().add(r);
                                                                                        gEx('gAlias').startEditing(gEx('gAlias').getStore().getCount()-1,1);
                                                                                        
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover alias',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=gEx('gAlias').getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el alias que desea remover');
                                                                                            return;
                                                                                        }
                                                                                        
                                                                                       gEx('gAlias').getStore().remove(fila); 
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;		
}


function tipoPersonaComboCP(combo,registro)
{
	gEx('lblErrorCedula_1').hide();
    gEx('lblErrorCedula_2').hide();
    gEx('lblErrorCedula_3').hide();
    gEx('lblErrorCedula_4').hide();
    gEx('lblErrorCedula_5').hide();
    gEx('lblErrorCedula_6').hide();
    
	var objConf=gEx('vParticipante').objConf;
	
	switch(registro.data.id)
    {
        case '1':
        	gEx('lblSinDigito').hide();
        	gEx('lblDesconoceNIT').hide();
            gEx('lblDesconoceNIT').setValue(false);
            gEx('lblTipoEntidad').hide();
            gEx('cmbTipoEntidad').setValue('');
            gEx('divTipoEntidad').hide();
            if(naturaleza!='A')
            {
            	gEx('lblSinIdentificacion').show();
            }
            gEx('lblDivComboIdentificacion').show();
            gEx('lblNombre').show();
            gEx('lblRazonSocial').hide();

            gEx('txtRazonSocial').setValue('');
            gEx('txtRazonSocial').hide();

            gEx('txtNombre').show();
            gEx('txtApPaterno').show();
            gEx('txtApMaterno').show();
            gEx('lblApPaterno').show();
            gEx('lblApMaterno').show();
            
           	gEx('tblPersona').unhideTabStripItem(1);
                
                

            gEx('cmbIdentificacion').show();
            gEx('txtEspecifique').show();
            gEx('lblIdentificacion').setText('Tipo de identificaci&oacute;n: <span style="color:#F00">*</span>',false);
            gEx('lblIdentificacion').setPosition(10,120);
            gEx('lblNoIdentificacion').show();
            gEx('txtNIT').hide();
            gEx('txtNIT').setValue('');  
           	gEx('txtNombre').focus();
            
            gEx('lblFechaExpedicion').show();
            if(conoceFechaExpedicion=='1')
	            gEx('lblValFechaExpedicion').show();
            else
            	gEx('lblValFechaExpedicion').hide();
            gEx('divFechaDocumento').show();
            
            if(tipoParticipanteActual=='5')
            {
            
                gEx('lblTarjetaProfesional').show();
                gEx('txtTarjetaProfesional').show();
			}            

        break;
        case '2':
        	gEx('lblSinDigito').show();
        	gEx('lblDesconoceNIT').show();
            gEx('lblDivComboIdentificacion').hide();
            gEx('txtRazonSocial').show();
            gEx('divTipoEntidad').show();
            gEx('cmbTipoEntidad').setValue('2');
			gEx('lblSinIdentificacion').hide();
            gEx('lblTipoEntidad').show();
            gEx('lblNombre').hide();
            gEx('lblRazonSocial').show();
            
            gEx('txtNombre').hide();
            gEx('txtApPaterno').hide();
            gEx('txtApMaterno').hide();
            
            gEx('txtNombre').setValue('');
            gEx('txtApPaterno').setValue('');
            gEx('txtApMaterno').setValue('');
            gEx('cmbGenero').setValue('');
            
            gEx('lblApPaterno').hide();
            gEx('lblApMaterno').hide();
            gEx('fechaNacimiento').setValue('');
            gEx('txtEdad').setValue('');
            
            gEx('cmbIdentificacion').hide();
            gEx('cmbIdentificacion').setValue('');
            gEx('txtEspecifique').hide();
            gEx('txtEspecifique').setValue('');
            
            gEx('txtEspecifique').ultimaValidacion='';
            gEx('txtEspecifique').ultimaBusqueda='';
            gEx('lblIdentificacion').setText('N&uacute;mero de Identificaci&oacute;n Tributaria (NIT): <span style="color:#F00">*</span>',false);
            gEx('lblIdentificacion').setPosition(10,170);
            gEx('lblNoIdentificacion').hide();
            gEx('txtNIT').show();
            gEx('txtNIT').focus();
            gEx('tblPersona').hideTabStripItem(1);
            
            
            gEx('lblFechaExpedicion').hide();
            gEx('lblValFechaExpedicion').hide();
            gEx('divFechaDocumento').hide();
            gEx('lblTarjetaProfesional').hide();
            gEx('txtTarjetaProfesional').hide();
        break;
        
    }
    
}





function crearArbolSujetosProcesalesRelacion(iA,iP,parteProcesal)
{
	var iActividad=iA?iA:-1;
    var idPersona=iP?iP:-1;
	var raiz=new  Ext.tree.AsyncTreeNode(
											{
												id:'-1',
												text:'Raiz',
												draggable:false,
												expanded :false,
												cls:'-1'
											}
										)
										
	var cargadorArbol=new Ext.tree.TreeLoader(
                                                {
                                                    baseParams:{
                                                                    funcion:'19',
                                                                    iC:gE('idCarpetaAdministrativa')?gE('idCarpetaAdministrativa').value:-1,
                                                                    cA:gE('carpetaAdministrativa')?gE('carpetaAdministrativa').value:-1,
                                                                    iA:iActividad,
                                                                    check:1,
                                                                    iP:idPersona
                                                                },
                                                    dataUrl:'../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php'
                                                }
                                            )		
										
	cargadorArbol.on('beforeload',function(c)
    						{
                            	buscarPartesAsociar(parteProcesal);
                            	c.baseParams.sujetosProcesales=listPartes;
                                if(listPartes=='-1')
                                {
                                	gEx('tblPersona').hideTabStripItem(3);
                                }
                                else
                                	gEx('tblPersona').unhideTabStripItem(3);

                            }
    				)	
    										
	cargadorArbol.on('load',function(c,nodoCarga)
    						{
                            	
                            }
    				)										
	var arbolSujetosJuridicos=new Ext.tree.TreePanel	(
                                                            {
                                                                id:'arbolSujetosRelacion',
                                                                useArrows:true,
                                                                animate:true,
                                                                enableDD:false,
                                                                ddScroll:true,
																region:'center',
                                                                containerScroll: true,
                                                                autoScroll:true,
                                                                border:true,
                                                                root:raiz,
                                                                cls:'treeControlSIUGJ',
                                                                loader: cargadorArbol,
                                                                rootVisible:false
                                                            }
                                                        )
         
         
                                                    
	return  arbolSujetosJuridicos;
}


function buscarParticipante(valor,tipoBusqueda,campo)
{
	function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
           if(arrResp[1]!='0')
           {
           		mostrarVentanaExisteParticipante(arrResp[1],arrResp[2],campo,tipoBusqueda);
           }
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=208&tipoBusqueda='+tipoBusqueda+'&valor='+valor,true);
}

function mostrarVentanaExisteParticipante(valor,nombre,campo,tipoBusqueda)
{
	function respExiste(btn)
    {
    	if(btn=='yes')
        {
        	var vParticipante=gEx('vParticipante');
            var objConf=vParticipante.objConf;
            var listPartes=vParticipante.listPartes;
            var tipoParticipante=vParticipante.tipoParticipante;
            if(listPartes=='-1')
            {
            	var cadObj='{"idActividad":"'+objConf.idActividad+'","idCarpeta":"'+objConf.idCarpeta+'","idFiguraJuridica":"'+tipoParticipante+
                			'","relacion":"","idParticipante":"'+valor+'"}';
                
                
                function respEx(btn)
                {
                	if(btn=='yes')
                    {
                    	guardarRelacionFiguraExistente(cadObj,valor,nombre,tipoParticipante);
                    }
                }
                msgConfirm('Est&aacute; seguro de querer agregar a la persona: <b>'+nombre+'</b>?',respEx);
                
            }
            else
            {
            	mostrarVentanaSeleccionRelacion(valor,nombre,listPartes,tipoBusqueda);
            }
            
            
        
        }
        else
        {
        	var nombreCampo='';
        	switch(tipoBusqueda)
            {
            	case 1:
                	nombreCampo='txtCedula';
                break;
                case 2:
                	nombreCampo='txtCURP';
                break;
                case 3:
                	nombreCampo='txtRFC';
                break;
            }
        	gEx(nombreCampo).setValue('');
            gEx(nombreCampo).focus();
        }
    }
	msgConfirm('Se ha detectado que existe una persona con '+campo+', con el nombre de: <b>'+nombre+'</b>, es la persona que desea agregar?',respExiste)
}

function mostrarVentanaSeleccionRelacion(valor,nombre,listPartes,tipoBusqueda)
{
	
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			crearArbolSujetosProcesalesRelacionSeleccion(listPartes)
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Personas que se relacionan con: '+nombre,
                                        id:'vAddRelacion',
										width: 610,
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
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var listaRelacion='';
                                                                        var arrNodos=obtenerNodoChecados(gEx('arbolSujetosRelacionSeleccion').getRootNode());
                                                                        var x;
                                                                        for(x=0;x<arrNodos.length;x++)
                                                                        {
                                                                        	if(listaRelacion=='')
                                                                            {
                                                                            	listaRelacion=arrNodos[x].attributes.idPersona;
                                                                            }
                                                                            else
                                                                            {
                                                                            	listaRelacion+=','+arrNodos[x].attributes.idPersona;
                                                                            }
                                                                        }
                                                                        
                                                                        var vParticipante=gEx('vParticipante');
                                                                        var objConf=vParticipante.objConf;
                                                                        var listPartes=vParticipante.listPartes;
                                                                        var tipoParticipante=vParticipante.tipoParticipante;
                                                                        
                                                                        var cadObj='{"idActividad":"'+objConf.idActividad+'","idCarpeta":"'+objConf.idCarpeta+
                                                                        			'","idFiguraJuridica":"'+tipoParticipante+'","relacion":"'+listaRelacion+
                                                                                    '","idParticipante":"'+valor+'"}';
                                                                        guardarRelacionFiguraExistente(cadObj,valor,nombre,tipoParticipante);
                                                                        
																	}
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
															handler:function()
																	{
                                                                    	var nombreCampo='';
                                                                        switch(tipoBusqueda)
                                                                        {
                                                                            case 1:
                                                                                nombreCampo='txtCedula';
                                                                            break;
                                                                            case 2:
                                                                                nombreCampo='txtCURP';
                                                                            break;
                                                                            case 3:
                                                                                nombreCampo='txtRFC';
                                                                            break;
                                                                        }
                                                                        gEx(nombreCampo).setValue('');
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();
}

function crearArbolSujetosProcesalesRelacionSeleccion(listPartes)
{
	var vParticipante=gEx('vParticipante');
    var objConf=vParticipante.objConf;
    var listPartes=vParticipante.listPartes;
    var tipoParticipante=vParticipante.tipoParticipante;
	var raiz=new  Ext.tree.AsyncTreeNode(
											{
												id:'-1',
												text:'Raiz',
												draggable:false,
												expanded :false,
												cls:'-1'
											}
										)
										
	var cargadorArbol=new Ext.tree.TreeLoader(
                                                {
                                                    baseParams:{
                                                                    funcion:'19',
                                                                    iC:objConf.idCarpeta,
                                                                    cA:objConf.carpetaAdministrativa,
                                                                    check:1,
                                                                    sujetosProcesales:listPartes
                                                                },
                                                    dataUrl:'../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php'
                                                }
                                            )		
										
	cargadorArbol.on('beforeload',function(c)
    						{
                            }
    				)	
    										
	cargadorArbol.on('load',function(c,nodoCarga)
    						{
                            	setTimeout(	function()
                                			{
                                            
                                                var listaRelacion='';
                                                var arrNodos=obtenerNodoChecados(gEx('arbolSujetosRelacion').getRootNode());
                                                var x;
                                                var nodoSelParticipante;
                                                for(x=0;x<arrNodos.length;x++)
                                                {
                                                	nodoSelParticipante=gEx('arbolSujetosRelacionSeleccion').getNodeById(arrNodos[x].id);
                                                	nodoSelParticipante.getUI().toggleCheck(true);
                                                }
                                             },200
                                           )
                            }
    				)										
	var arbolSujetosRelacionSeleccion=new Ext.tree.TreePanel	(
                                                                    {
                                                                        id:'arbolSujetosRelacionSeleccion',
                                                                        useArrows:true,
                                                                        animate:true,
                                                                        enableDD:false,
                                                                        ddScroll:true,
                                                                        title:'Relacionado con:',
                                                                        containerScroll: true,
                                                                        autoScroll:true,
                                                                        border:true,
                                                                        x:10,
                                                                        y:0,
                                                                        disabled:listPartes=='-1',
                                                                        height:350,
                                                                        width:550,
                                                                        root:raiz,
                                                                        loader: cargadorArbol,
                                                                        rootVisible:false
                                                                    }
                                                                )
         
         
                                                    
	return  arbolSujetosRelacionSeleccion;
}

function guardarRelacionFiguraExistente(cadObj,idFigura,nombre,tipoParticipante)
{
	var vParticipante=gEx('vParticipante');
	var objConf=vParticipante.objConf;
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            if(gEx('vAddRelacion'))
            	gEx('vAddRelacion').close();
            if(gEx('vParticipante'))
                gEx('vParticipante').close();
                
            if(objConf && objConf.afterRegister)
            	objConf.afterRegister(idFigura,nombre,tipoParticipante);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=209&cadObj='+cadObj,true);
}

function calcularEdadParticipante(fechaNacimiento)
{
	
    var edad=0;
    
    var fechaActual=Date.parseDate('<?php echo date("Y-m-d")?>','Y-m-d');
    
    
    fechaCumpleados=Date.parseDate(fechaActual.format("Y")+'-'+fechaNacimiento.format('m-d'),'Y-m-d');
    
    edad=parseInt(fechaActual.format('Y'))-parseInt(fechaNacimiento.format('Y'));
    if(fechaCumpleados>fechaActual)
    {
    	edad--;
    }
    
    
    
    return edad;
}


function obtenerDatosIdentificacionVentana(idParticipanteContacto,personaJuridica,ventanaAM,objConf)
{
	function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	
        	var cObjeto=eval('['+arrResp[1]+']')[0];
            
          	
           
			gEx('txtNombre').setValue(cObjeto.datosParticipante.nombre);
                
          	gEx('txtApPaterno').setValue(cObjeto.datosParticipante.apellidoPaterno);
          
            gEx('txtApMaterno').setValue(cObjeto.datosParticipante.apellidoMaterno);
            
            if(cObjeto.datosParticipante.tipoPersona=='1')
            {
                gEx('cmbIdentificacion').setValue(cObjeto.datosParticipante.tipoIdentificacion);
                
                gEx('txtEspecifique').ultimaBusqueda=cObjeto.datosParticipante.folioIdentificacion;
                gEx('txtEspecifique').setValue(cObjeto.datosParticipante.folioIdentificacion);
			}
            else
            {
            	gEx('txtNIT').ultimaBusqueda=cObjeto.datosParticipante.folioIdentificacion;
            	gEx('txtNIT').setValue(cObjeto.datosParticipante.folioIdentificacion);
            }
                        
            
            gEx('txtTarjetaProfesional').setValue(cObjeto.datosParticipante.tarjetaProfesional);
            gEx('fechaNacimiento').setValue(cObjeto.datosParticipante.fechaNacimiento);
            gEx('fechaIdentificacion').setValue(cObjeto.datosParticipante.fechaIdentificacion);
            gEx('cmbTipoEntidad').setValue(cObjeto.datosParticipante.tipoEntidad);
            if(cObjeto.datosParticipante.fechaNacimiento!='')
            {
                gEx('fechaNacimiento').fireEvent('change',gEx('fechaNacimiento'),gEx('fechaNacimiento').getValue());
            }
            
            gEx('cmbGenero').setValue(cObjeto.datosParticipante.genero);
            gEx('cmbGrupoEtnico').setValue(cObjeto.datosParticipante.grupoEtnico);
            gEx('cmbDiscapacidad').setValue(cObjeto.datosParticipante.discapacidad);
            
            var txtCalle=gEx('txtCalleCParticipante');
            txtCalle.setValue(cObjeto.datosContacto.calle);
            var txtNoExt=gEx('txtNoExtCParticipante');
            txtNoExt.setValue(cObjeto.datosContacto.noExt);
            var txtNoInt=gEx('txtNoIntCParticipante');
            txtNoInt.setValue(cObjeto.datosContacto.noInt);
            var txtColonia=gEx('txtColoniaCParticipante');
            txtColonia.setValue(cObjeto.datosContacto.colonia);
            var txtCP=gEx('txtCPCParticipante');
            txtCP.setValue(cObjeto.datosContacto.cp=='NULL'?'':cObjeto.datosContacto.cp);
            var txtLocalidad=gEx('txtLocalidadCParticipante');
            txtLocalidad.setValue(cObjeto.datosContacto.localidad);
            var txtEntreCalle=gEx('txtEntreCalleCParticipante');
            txtEntreCalle.setValue(cObjeto.datosContacto.entreCalle);
            var txtYCalle=gEx('txtYCalleCParticipante');
            txtYCalle.setValue(cObjeto.datosContacto.yCalle);
            var txtReferencias=gEx('txtReferenciasCParticipante');
            txtReferencias.setValue(cObjeto.datosContacto.referencias);
            var cmbEstado=gEx('cmbEstadoCParticipante');
            cmbEstado.setValue(cObjeto.datosContacto.estado);
            var cmbMunicipio=gEx('cmbMunicipioCParticipante');
          
          
          
            var posFila=obtenerPosFila(cmbEstado.getStore(),'id',cObjeto.datosContacto.estado);
            if(posFila!=-1)
            {
                var registro=cmbEstado.getStore().getAt(posFila);
                obtenerMunicipiosCParticipante(cmbEstado,registro,function()
                                                                    {
                                                                        cmbMunicipio.setValue(cObjeto.datosContacto.municipio);
                                                                    }
                                            )
            }            
            
            var arrDatosTelefono=[];
            var x;
            var f;
            for(x=0;x<cObjeto.datosContacto.telefonos.length;x++)
            {
                f=cObjeto.datosContacto.telefonos[x];
                if(f.numero!='No registra información.')
                {
                    arrDatosTelefono.push([f.tipoTelefono,f.idPais,f.lada,f.numero,f.extension]);
                }
            }
            
            
            gEx('gTelefonosCParticipante').getStore().loadData(arrDatosTelefono);
            
            var arrMails=[];
            for(x=0;x<cObjeto.datosContacto.correos.length;x++)
            {
                f=cObjeto.datosContacto.correos[x];
            
                if(validarCorreo(f.mail))
                {
                    arrMails.push([f.mail]);
                }
                
            }
            
            gEx('gMailCParticipante').getStore().loadData(arrMails);
            
            
            gEx('cmbTipoPersona').setValue(cObjeto.datosParticipante.tipoPersona);
            dispararEventoSelectCombo('cmbTipoPersona');
            
            if(cObjeto.datosParticipante.tipoPersona!='1')
            {
                gEx('txtRazonSocial').setValue(cObjeto.datosParticipante.nombre);
                
            }
              
              
            gEx('lblDesconoceNIT').setValue(cObjeto.datosParticipante.desconoceNIT=='1');
            gEx('lblSinIdentificacion').setValue(cObjeto.datosParticipante.desconoceIdentificacion=='1');
            gEx('lblDesconoceDatoContacto').setValue(cObjeto.datosParticipante.desconoceDomicilio=='1');  

			
			gEx('lblDesconoceNIT').fireEvent('check',gEx('lblDesconoceNIT'),gEx('lblDesconoceNIT').getValue());
            gEx('lblSinIdentificacion').fireEvent('check',gEx('lblSinIdentificacion'),gEx('lblSinIdentificacion').getValue());
            gEx('lblDesconoceDatoContacto').fireEvent('check',gEx('lblDesconoceDatoContacto'),gEx('lblDesconoceDatoContacto').getValue());
              
           
            gEx('aceptaNotificacion_1').setValue(cObjeto.datosParticipante.aceptaNotificacionMail=='1');
            gEx('aceptaNotificacion_0').setValue(cObjeto.datosParticipante.aceptaNotificacionMail=='0');
            
            
            if(cObjeto.datosParticipante.busquedaWS=='1')  
            {
                gEx('cmbIdentificacion').disable();
                gEx('txtRazonSocial').disable();
                gEx('txtEspecifique').disable();
                gEx('txtNombre').disable();
                gEx('txtApPaterno').disable();
                gEx('txtApMaterno').disable();
                gEx('txtTarjetaProfesional').disable();
                txtCalle.disable();
                txtNoExt.disable();
                txtNoInt.disable();
                txtColonia.disable();
                txtCP.disable();
                txtLocalidad.disable();
                txtEntreCalle.disable();
                txtYCalle.disable();
                txtReferencias.disable();
                cmbEstado.disable();
                cmbMunicipio.disable();
                gEx('gTelefonosCParticipante').disable();
                gEx('cmbTipoPersona').disable();
                gEx('gMailCParticipante').disable();
                gEx('lblSinIdentificacion').hide();
                gEx('cmbTipoEntidad').disable();
                gEx('lblDesconoceNIT').hide();
            }
            else
            	gEx('txtRazonSocial').enable()
            
            ventanaAM.show();
            
		}
        else
        {
              msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=210&idActividad='+
    				((objConf  && objConf.idActividad)?objConf.idActividad:idActividad)+'&idParticipante='+idParticipanteContacto,true);

}

function obtenerMunicipiosCParticipante(cmb,registro,funcAfterLoad)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var arrDatos=eval(arrResp[1]);
            gEx('cmbMunicipioCParticipante').setValue('');
            gEx('cmbMunicipioCParticipante').getStore().loadData(arrDatos);
            if(funcAfterLoad)
            	funcAfterLoad();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=89&cveEstado='+registro.data.id,true);
    
}

function buscarPersona(nPersona,tB,figuraJuridica)
{
	gEx('lblErrorCedula_1').hide();
    gEx('lblErrorCedula_2').hide();
    gEx('lblErrorCedula_3').hide();
    gEx('lblErrorCedula_4').hide();
    gEx('lblErrorCedula_5').hide();
    gEx('lblErrorCedula_6').hide();
    
	if((tB==0)&&(ignorarBusquedaMail))
    {
    	return;
    }
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        
        	
            if(arrResp[1]=='1')
            {
            	esBusquedaPersona=true;
                resultadoBusquedaWS=false;
            	cObjeto=eval('['+bD(arrResp[2])+']')[0];
                var arrMails=[];

                

                if(cObjeto.datosParticipante.idParticipante=='-1')
                {
                	ignorarBusquedaMail=true;
                }
                else
                    if(cObjeto.datosParticipante.idParticipante=='0')//Sirna-rues
                    {
                        cObjeto.datosParticipante.idParticipante=-1;
                        esBusquedaPersona=false;
                        ignorarBusquedaMail=true;
                        resultadoBusquedaWS=true;
                        
                    }
                    else
                    {
                    	if(!cObjeto.datosParticipante.idParticipante)
                        {
                        	 esBusquedaPersona=false;
                        }
                        //BD Siugj
                    }
                    
                if(cObjeto.datosParticipante.idParticipante)    
	                idPersonaEncontrada=cObjeto.datosParticipante.idParticipante;
                
                           
                
                
                if(typeof(cObjeto.datosParticipante.nombre)!='undefined')
                {
                	
                    gEx('txtNombre').setValue(cObjeto.datosParticipante.nombre);
                    
                    gEx('txtApPaterno').setValue(cObjeto.datosParticipante.apellidoPaterno);
                    
                    gEx('txtApMaterno').setValue(cObjeto.datosParticipante.apellidoMaterno);
                    
                    gEx('cmbIdentificacion').setValue(cObjeto.datosParticipante.tipoIdentificacion);
                    gEx('txtEspecifique').setValue(cObjeto.datosParticipante.folioIdentificacion);
                    gEx('txtTarjetaProfesional').setValue(cObjeto.datosParticipante.tarjetaProfesional);
                    gEx('fechaNacimiento').setValue(cObjeto.datosParticipante.fechaNacimiento);
                    gEx('fechaIdentificacion').setValue(cObjeto.datosParticipante.fechaIdentificacion);
                    gEx('cmbTipoEntidad').setValue(cObjeto.datosParticipante.tipoEntidad);
				}
                
                
               
                if(typeof(cObjeto.datosParticipante.fechaNacimiento)!='undefined')
                {
                    if(cObjeto.datosParticipante.fechaNacimiento!='')
                    {
                        gEx('fechaNacimiento').fireEvent('change',gEx('fechaNacimiento'),gEx('fechaNacimiento').getValue());
                    }
                    
                    gEx('cmbGenero').setValue(cObjeto.datosParticipante.genero);
                    gEx('cmbGrupoEtnico').setValue(cObjeto.datosParticipante.grupoEtnico);
                    gEx('cmbDiscapacidad').setValue(cObjeto.datosParticipante.discapacidad);
    
                    var txtCalle=gEx('txtCalleCParticipante');
                    txtCalle.setValue(cObjeto.datosContacto.calle);
                    var txtNoExt=gEx('txtNoExtCParticipante');
                    txtNoExt.setValue(cObjeto.datosContacto.noExt);
                    var txtNoInt=gEx('txtNoIntCParticipante');
                    txtNoInt.setValue(cObjeto.datosContacto.noInt);
                    var txtColonia=gEx('txtColoniaCParticipante');
                    txtColonia.setValue(cObjeto.datosContacto.colonia);
                    var txtCP=gEx('txtCPCParticipante');
                    txtCP.setValue(cObjeto.datosContacto.cp=='NULL'?'':cObjeto.datosContacto.cp);
                    var txtLocalidad=gEx('txtLocalidadCParticipante');
                    txtLocalidad.setValue(cObjeto.datosContacto.localidad);
                    var txtEntreCalle=gEx('txtEntreCalleCParticipante');
                    txtEntreCalle.setValue(cObjeto.datosContacto.entreCalle);
                    var txtYCalle=gEx('txtYCalleCParticipante');
                    txtYCalle.setValue(cObjeto.datosContacto.yCalle);
                    var txtReferencias=gEx('txtReferenciasCParticipante');
                    txtReferencias.setValue(cObjeto.datosContacto.referencias);
                    var cmbEstado=gEx('cmbEstadoCParticipante');
                    cmbEstado.setValue(cObjeto.datosContacto.estado);
                    var cmbMunicipio=gEx('cmbMunicipioCParticipante');
                
                    var posFila=obtenerPosFila(cmbEstado.getStore(),'id',cObjeto.datosContacto.estado);
                    if(posFila!=-1)
                    {
                        var registro=cmbEstado.getStore().getAt(posFila);
                        obtenerMunicipiosCParticipante(cmbEstado,registro,function()
                                                                            {
                                                                                cmbMunicipio.setValue(cObjeto.datosContacto.municipio);
                                                                            }
                                                    )
                    }            
                    
                    
                    
                    var arrDatosTelefono=[];
                    var x;
                    var f;
                    for(x=0;x<cObjeto.datosContacto.telefonos.length;x++)
                    {
                        f=cObjeto.datosContacto.telefonos[x];
                        if(f.numero!='No registra información.')
                        {
                            arrDatosTelefono.push([f.tipoTelefono,f.idPais,f.lada,f.numero,f.extension]);
                            
                        }
                        
                    }
                    
                    
                    gEx('gTelefonosCParticipante').getStore().loadData(arrDatosTelefono);
                    
                    
                    for(x=0;x<cObjeto.datosContacto.correos.length;x++)
                    {
                        f=cObjeto.datosContacto.correos[x];
    
                        if(validarCorreo(f.mail))
                        {
                            arrMails.push([f.mail]);
                        }
                        
                    }
                    
                    gEx('gMailCParticipante').getStore().loadData(arrMails);
                
                }
                if(cObjeto.datosParticipante.tipoPersona)
                {
                    gEx('cmbTipoPersona').setValue(cObjeto.datosParticipante.tipoPersona);
                    dispararEventoSelectCombo('cmbTipoPersona');
                
                    if(cObjeto.datosParticipante.tipoPersona!='1')
                    {
                        gEx('txtRazonSocial').setValue(cObjeto.datosParticipante.nombre);
                        if(cObjeto.datosParticipante.busquedaWS=='1')
	                        gEx('txtRazonSocial').disable();
                        else
                        	gEx('txtRazonSocial').enable();
                    }
				}                
              	
                if(cObjeto.validaCedulaProfesional=='1')
                {
                	if(cObjeto.situacionCedula=='-1') //La cedula no existe
                    {
                    	gEx('lblErrorCedula_1').show();
                        gEx('btnAceptarAddPersona').disable();
                        esBusquedaPersona=true;
                        
                    }
                    
                    if(cObjeto.situacionCedula=='2') //no vigente
                    {

                    	gEx('lblErrorCedula_2').show();
                        gEx('btnAceptarAddPersona').disable();
                    }
                    
                    if(cObjeto.situacionCedula=='1') //vigente
                    {
                    	gEx('lblErrorCedula_3').show();
                        gEx('btnAceptarAddPersona').enable();
                    }
                    
                    if(cObjeto.situacionCedula=='0') //Error en consulta
                    {

                    	gEx('lblErrorCedula_4').show();
                        resultadoBusquedaWS=false;
                        //gEx('btnAceptarAddPersona').disable();
                    }
                    
                    if(cObjeto.situacionCedula=='-1000') //La cedula no existe
                    {
                    	gEx('lblErrorCedula_5').show();
                        gEx('btnAceptarAddPersona').disable();
                        
                        
                        
                        
                    }
                    
                    if(cObjeto.situacionCedula=='-1001') //Error en consulta
                    {
                    	gEx('lblErrorCedula_6').show();
                        
                        resultadoBusquedaWS=false;
                        //gEx('btnAceptarAddPersona').disable();
                    }
                    
                    if(cObjeto.situacionCedula=='-1002')
                    {
                    	gEx('btnAceptarAddPersona').enable();
                    }
                }
                
                
                
                if(esBusquedaPersona)
                {
                    
                    gEx('cmbIdentificacion').disable();
                    gEx('txtEspecifique').disable();
                    gEx('txtNombre').disable();
                    gEx('txtApPaterno').disable();
                    gEx('txtApMaterno').disable();
                         
                    gEx('cmbGenero').disable();
                    gEx('txtEdad').disable();
                    gEx('cmbGrupoEtnico').disable();
                    gEx('cmbDiscapacidad').disable();
                    gEx('fechaNacimiento').disable(); 
                    
                    
                    

                    gEx('txtTarjetaProfesional').disable();
                    
                    
	                gEx('txtCalleCParticipante').disable();
                    
                    gEx('txtNoExtCParticipante').disable();
                    gEx('txtNoIntCParticipante').disable();
                    gEx('txtColoniaCParticipante').disable();
                    gEx('txtCPCParticipante').disable();
                    gEx('txtLocalidadCParticipante').disable();
                    gEx('txtEntreCalleCParticipante').disable();
                    gEx('txtYCalleCParticipante').disable();
                    gEx('txtReferenciasCParticipante').disable();
                    gEx('cmbEstadoCParticipante').disable();

                    gEx('cmbMunicipioCParticipante').disable();
                    gEx('gTelefonosCParticipante').disable();
                    gEx('cmbTipoPersona').disable();
                    gEx('fechaIdentificacion').disable();
                    gEx('gMailCParticipante').disable();
                    gEx('lblSinIdentificacion').hide();
                    gEx('cmbTipoEntidad').disable();
                    gEx('lblDesconoceNIT').hide();
                    gEx('txtRazonSocial').disable();
                    gEx('lblDesconoceDatoContacto').hide();
                    gEx('txtNIT').disable();
                    
                    if(gEx('lblValDireccion').isVisible() && gEx('txtCalleCParticipante').getValue()=='')
	                    gEx('txtCalleCParticipante').enable();
                        
                        
                    if(gEx('lblValDepto').isVisible() && gEx('cmbEstadoCParticipante').getValue()=='')
	                    gEx('cmbEstadoCParticipante').enable();
                    
                    
                    if(gEx('lblValCiudad').isVisible() && (cObjeto.datosContacto.municipio==''))
	                    gEx('cmbMunicipioCParticipante').enable();
                   
                   
                   if(gEx('cmbGrupoEtnico').getValue()=='')
                   {
                   		gEx('cmbGrupoEtnico').enable();
                   }
                   
                    if(gEx('cmbDiscapacidad').getValue()=='')
                   {
                   		gEx('cmbDiscapacidad').enable();
                   }
                   
                    if(gEx('fechaNacimiento').getValue()=='')
                   {
                   		gEx('fechaNacimiento').enable();
                   }
                   
                  ; 
                   
                } 
                
                if((resultadoBusquedaWS)  &&(cObjeto.situacionCedula!='-1') &&(cObjeto.situacionCedula!='0') &&(cObjeto.situacionCedula!='-1001'))
                {
                	gEx('cmbIdentificacion').disable();
                    gEx('txtEspecifique').disable();
                    gEx('txtNombre').disable();
                    gEx('txtApPaterno').disable();
                    gEx('txtApMaterno').disable();
                    gEx('txtTarjetaProfesional').disable();
                    gEx('txtCalleCParticipante').disable();
                    gEx('txtNoExtCParticipante').disable();
                    gEx('txtNoIntCParticipante').disable();
                    gEx('txtColoniaCParticipante').disable();
                    gEx('txtCPCParticipante').disable();
                    gEx('txtLocalidadCParticipante').disable();
                    gEx('txtEntreCalleCParticipante').disable();
                    gEx('txtYCalleCParticipante').disable();
                    gEx('txtReferenciasCParticipante').disable();
                    gEx('cmbEstadoCParticipante').disable();
                    gEx('cmbMunicipioCParticipante').disable();
                    gEx('gTelefonosCParticipante').disable();
                    gEx('cmbTipoPersona').disable();
                    gEx('gMailCParticipante').disable();
                    gEx('lblSinIdentificacion').hide();
                    gEx('cmbTipoEntidad').disable();
                    gEx('lblDesconoceNIT').hide();
                    gEx('txtRazonSocial').disable();
                    gEx('lblDesconoceDatoContacto').hide();
                    gEx('txtNIT').disable();
                    
                    
                    if(gEx('lblValDireccion').isVisible() && gEx('txtCalleCParticipante').getValue()=='')
	                    gEx('txtCalleCParticipante').enable();
                        
                        
                    if(gEx('lblValDepto').isVisible() && gEx('cmbEstadoCParticipante').getValue()=='')
	                    gEx('cmbEstadoCParticipante').enable();
                    
                    
                    if(gEx('lblValCiudad').isVisible() && (cObjeto.datosContacto.municipio==''))
	                    gEx('cmbMunicipioCParticipante').enable();
                    
                    
                }
                
                if(cObjeto.validaCedulaProfesional=='1')
                {
                	if(cObjeto.situacionCedula=='-1') //La cedula no existe
                    {
                        gEx('txtEspecifique').enable();
                        gEx('txtEspecifique').focus();
                    }
                    
                    if(cObjeto.situacionCedula=='0') //Error en consulta
                    {


                        gEx('txtTarjetaProfesional').enable();
                    }
                    
                    
                    
                	if(cObjeto.situacionCedula=='-1000') //La cedula no existe
                    {
                    	gEx('lblErrorCedula_5').show();
                        gEx('txtNIT').enable();
                        gEx('txtNIT').focus();
                        gEx('btnAceptarAddPersona').disable();
                        
                        
                        
                        
                    }
                }
                
                if(arrMails.length==0)
                {
                	
                    gEx('lblNoCorreo').setText('<div id="lblNoCorreo" class="SIUGJ_Etiqueta" style="color:#F00 !important;">&nbsp;&nbsp;No registra información de correo electrónico</div>',false);
                }
                
                
            }
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesModuloRegistroPartes.php',funcAjax, 'POST','funcion=2&iF='+figuraJuridica+
    				'&tB='+tB+'&vB='+nPersona+'&tipoEntidad='+gEx('cmbTipoEntidad').getValue(),true);
    
}



function deshabilitarNumeroIdentificacion(tipoIdentificacion,registro)
{
	gEx('txtEspecifique').hide();
    gEx('txtEspecifique').setValue('');
    gEx('txtEspecifique').ultimaValidacion='';
    gEx('txtEspecifique').ultimaBusqueda='';
    gEx('lblNoIdentificacion').hide();
}

function habilitarNumeroIdentificacion(tipoIdentificacion,registro)
{
	gEx('txtEspecifique').show();
    gEx('lblNoIdentificacion').show();
    gEx('txtEspecifique').setValue('');
    gEx('txtEspecifique').ultimaValidacion='';
    
    gEx('txtEspecifique').ultimaBusqueda='';
    
    gEx('txtTarjetaProfesional').setValue('');
    
    
    gEx('txtEspecifique').ultimaBusqueda='';
    
    gEx('lblErrorCedula_1').hide();
    gEx('lblErrorCedula_2').hide();
    gEx('lblErrorCedula_3').hide();
    gEx('lblErrorCedula_4').hide();
    gEx('lblErrorCedula_5').hide();
    gEx('lblErrorCedula_6').hide();
    
    
    
    
}


function validarNoIdentificacion(tipoValidacion)
{

	if((gEx('txtEspecifique').ultimaValidacion) && gEx('txtEspecifique').ultimaValidacion==gEx('txtEspecifique').getValue())
    {
    	return;
    }

	gEx('txtEspecifique').ultimaValidacion=gEx('txtEspecifique').getValue();
	var valor=gEx('txtEspecifique').getValue();
 	var tipoIdentificacion=gEx('cmbIdentificacion').getValue();
    var pos=existeValorMatriz(arrTipoIdentificacionConfiguracion,tipoIdentificacion);
    if(pos!=-1)
    {
    	var fila=arrTipoIdentificacionConfiguracion[pos];
        
        if(fila[2]!='')
        {
            var respuesta;
            eval('respuesta='+fila[2]+'(\''+valor+'\','+tipoValidacion+');');
            return respuesta;
        }
        return true;
        
    }
}


function validarCarnetDiplomatico(valor,tipoValidacion)
{
	var re=/[0-9A-Za-z]{11,11}$/;
	if(tipoValidacion==1)
    {
    	
        if(valor.length!=11)
        {
        	function resp()
            {
            	gEx('txtEspecifique').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n debe ser de 11 caracteres',resp);
        	return false;
        }
        
        
        if(!re.test(valor))
        {
        	function resp2()
            {
            	gEx('txtEspecifique').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (11 caracteres)',resp2);
        	return false;
        }
        return true;
        
    }
    else
    {
    	if(!re.test(valor))
        {
        	function resp3()
            {
            	gEx('txtEspecifique').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (11 caracteres)',resp3);
        	return false;
        }
        return true
    }
}

function validarCedulaCiudadania(valor,tipoValidacion)
{
	var re=/[0-9]{3,10}$/;
	if(tipoValidacion==1)
    {
    	
        if((valor.length<3)||(valor.length>10))
        {
        	function resp()
            {
            	gEx('txtEspecifique').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n debe ser de 3 a 10 caracteres',resp);
        	return false;
        }
        
        
        if(!re.test(valor))
        {
        	function resp2()
            {
            	gEx('txtEspecifique').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (3 a 10 d&iacute;gitos numericos)',resp2);
        	return false;
        }
        return true;
        
    }
    else
    {
    	if(!re.test(valor))
        {
        	function resp3()
            {
            	gEx('txtEspecifique').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (3 a 10 d&iacute;gitos numericos)',resp3);
        	return false;
        }
        return true
    }
}

function validarCedulaExtranjeria(valor,tipoValidacion)
{
	var re=/[0-9]{6,6}$/;
	if(tipoValidacion==1)
    {
    	
        if(valor.length!=6)
        {
        	function resp()
            {
            	gEx('txtEspecifique').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n debe ser de 6 caracteres',resp);
        	return false;
        }
        
        
        if(!re.test(valor))
        {
        	function resp2()
            {
            	gEx('txtEspecifique').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (6 d&iacute;gitos numericos)',resp2);
        	return false;
        }
        return true;
        
    }
    else
    {
    	if(!re.test(valor))
        {
        	function resp3()
            {
            	gEx('txtEspecifique').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (6 d&iacute;gitos numericos)',resp3);
        	return false;
        }
        return true
    }
}


function validarCetificadoNacimientoVivo(valor,tipoValidacion)
{
	var re=/[0-9]{9,9}$/;
	if(tipoValidacion==1)
    {
    	
        if(valor.length!=9)
        {
        	function resp()
            {
            	gEx('txtEspecifique').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n debe ser de 9 caracteres',resp);
        	return false;
        }
        
        
        if(!re.test(valor))
        {
        	function resp2()
            {
            	gEx('txtEspecifique').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (9 d&iacute;gitos numericos)',resp2);
        	return false;
        }
        return true;
        
    }
    else
    {
    	if(!re.test(valor))
        {
        	function resp3()
            {
            	gEx('txtEspecifique').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (9 d&iacute;gitos numericos)',resp3);
        	return false;
        }
        return true
    }
}

function validarDocumentoExtranjero(valor,tipoValidacion)
{
	var re=/[0-9A-Za-z]{16,16}$/;
	if(tipoValidacion==1)
    {
    	
        if(valor.length!=16)
        {
        	function resp()
            {
            	gEx('txtEspecifique').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n debe ser de 16 caracteres',resp);
        	return false;
        }
        
        
        if(!re.test(valor))
        {
        	function resp2()
            {
            	gEx('txtEspecifique').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (16 caracteres)',resp2);
        	return false;
        }
        return true;
        
    }
    else
    {
    	if(!re.test(valor))
        {
        	function resp3()
            {
            	gEx('txtEspecifique').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (16 caracteres)',resp3);
        	return false;
        }
        return true
    }
}

function validarPasaporte(valor,tipoValidacion)
{
	var re=/[0-9A-Za-z]{6,16}$/;
	if(tipoValidacion==1)
    {
        if((valor.length<6)||(valor.length>16))
        {
        	function resp()
            {
            	gE('txtEspecifique').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n debe ser de 6 a 16 caracteres',resp);
        	return false;
        }
        
        
        if(!re.test(valor))
        {
        	function resp2()
            {
            	gE('txtEspecifique').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (6 a 16 caracteres)',resp2);
        	return false;
        }
        return true;
        
    }
    else
    {
    	if(!re.test(valor))
        {
        	function resp3()
            {
            	gE('txtEspecifique').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (6 a 16 caracteres)',resp3);
        	return false;
        }
        return true
    }
}

function validarPermisoEspecialPermanencia(valor,tipoValidacion)
{
	var re=/[0-9]{15,15}$/;
	if(tipoValidacion==1)
    {
    	
        if(valor.length!=15)
        {
        	function resp()
            {
            	gEx('txtEspecifique').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n debe ser de 15 caracteres',resp);
        	return false;
        }
        
        
        if(!re.test(valor))
        {
        	function resp2()
            {
            	gEx('txtEspecifique').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (15 d&iacute;gitos numericos)',resp2);
        	return false;
        }
        return true;
        
    }
    else
    {
    	if(!re.test(valor))
        {
        	function resp3()
            {
            	gEx('txtEspecifique').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (15 d&iacute;gitos numericos)',resp3);
        	return false;
        }
        return true
    }
}

function validaRegistroCivilNacimiento(valor,tipoValidacion)
{
	var re=/[0-9]{11,11}$/;
	if(tipoValidacion==1)
    {
    	
        if(valor.length!=11)
        {
        	function resp()
            {
            	gEx('txtEspecifique').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n debe ser de 11 caracteres',resp);
        	return false;
        }
        
        
        if(!re.test(valor))
        {
        	function resp2()
            {
            	gEx('txtEspecifique').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (11 d&iacute;gitos numericos)',resp2);
        	return false;
        }
        return true;
        
    }
    else
    {
    	if(!re.test(valor))
        {
        	function resp3()
            {
            	gEx('txtEspecifique').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (11 d&iacute;gitos numericos)',resp3);
        	return false;
        }
        return true
    }
}

function validarSalvoConducto(valor,tipoValidacion)
{
	var re=/[0-9A-Za-z]{9,9}$/;
	if(tipoValidacion==1)
    {
    	
        if(valor.length!=9)
        {
        	function resp()
            {
            	gEx('txtEspecifique').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n debe ser de 9 caracteres',resp);
        	return false;
        }
        
        
        if(!re.test(valor))
        {
        	function resp2()
            {
            	gEx('txtEspecifique').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (9 caracteres)',resp2);
        	return false;
        }
        return true;
        
    }
    else
    {
    	if(!re.test(valor))
        {
        	function resp3()
            {
            	gEx('txtEspecifique').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (9 caracteres)',resp3);
        	return false;
        }
        return true
    }
}

function validarTarjetaIdentidad(valor,tipoValidacion)
{

	var re=/[0-9]{11,11}$/;
	if(tipoValidacion==1)
    {
    	
        if(valor.length!=11)
        {
        	function resp()
            {
            	gEx('txtEspecifique').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n debe ser de 11 digitos',resp);
        	return false;
        }
        
        
        if(!re.test(valor))
        {
        	function resp2()
            {
            	gEx('txtEspecifique').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (11 d&iacute;gitos)',resp2);
        	return false;
        }
        return true;
        
    }
    else
    {
    	if(!re.test(valor))
        {
        	function resp3()
            {
            	gEx('txtEspecifique').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido (11 d&iacute;gitos numericos)',resp3);
        	return false;
        }
        return true
    }
}


function validarNIT(valor,tipoValidacion)
{
	var re=/[0-9]{4,15}$/;
	if(tipoValidacion==1)
    {
    	
        if((valor.length<4)||(valor.length>15))
        {
        	function resp()
            {
            	gEx('txtNIT').focus();
            }
            msgBox('El N&uacute;mero de Identificaci&oacute;n Tributaria (NIT) debe ser de entre 4 y 15 digitos',resp);
        	return false;
        }
        
        
        if(!re.test(valor))
        {
        	function resp2()
            {
            	gEx('txtNIT').focus();
            }
            msgBox('El N&uacute;mero de Identificaci&oacute;n Tributaria (NIT) ingresado no cumple el formato permitido (Entre 4 y 15 d&iacute;gitos)',resp2);
        	return false;
        }
        return true;
        
    }
    else
    {
    	if(!re.test(valor))
        {
        	function resp3()
            {
            	gEx('txtNIT').focus();
            }
            msgBox('El N&uacute;mero de Identificaci&oacute;n Tributaria (NIT) ingresado no cumple el formato permitido (15 d&iacute;gitos numericos)',resp3);
        	return false;
        }
        return true
    }
}
