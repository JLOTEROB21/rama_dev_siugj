<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$listParteProcesal="";
	
	$consulta="SELECT id__5_tablaDinamica,nombreTipo FROM _5_tablaDinamica order by nombreTipo";
	$arrTipoFigura=$con->obtenerFilasArreglo($consulta);
	
	$arrParteProcesal="";
	
	$res=$con->obtenerFilas($consulta);
	while($filaFigura=mysql_fetch_row($res))
	{
		if($listParteProcesal=="")
			$listParteProcesal=$filaFigura[0];
		else
			$listParteProcesal.=",".$filaFigura[0];
		$consulta="SELECT idDetalle,etiquetaDetalle FROM _5_gDetallesTipo WHERE idReferencia=".$filaFigura[0];
		$arrDetalles=$con->obtenerFilasArreglo($consulta);
		$consulta="SELECT idOpcion FROM _5_tiposFiguras WHERE idPadre=".$filaFigura[0];
		$listFiguras=$con->obtenerListaValores($consulta);
		$o="['".$filaFigura[0]."','".cv($filaFigura[1])."',".$arrDetalles.",'".$listFiguras."']";
		if($arrParteProcesal=="")
			$arrParteProcesal=$o;
		else
			$arrParteProcesal.=",".$o;
		
		
	}
	
	if($listParteProcesal=="")
		$listParteProcesal=-1;
	$arrPartes="";
	
	$consulta="SELECT id__5_tablaDinamica,nombreTipo FROM _5_tablaDinamica where id__5_tablaDinamica in(".$listParteProcesal.") order by nombreTipo";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$o="{
				cls:'x-btn-text-icon',
				text:'".$fila[1]."',
				handler:function()
						{	
							
							var oConf=	{
											idActividad:gE('idActividad').value,
											ocultaRFC:true,
											ocultaCURP:true,
											idCarpeta:gE('idCarpetaAdministrativa').value,
											afterRegister:recargarArbolParticipantes,
											carpetaAdministrativa:gE('carpetaAdministrativa').value
										}
							agregarParticipanteVentana(".$fila[0].",'".cv($fila[1])."',oConf);
						}
				
			}";
		if($arrPartes=="")
			$arrPartes=$o;
		else			
			$arrPartes.=",".$o;
	}
	
	$arrPartes="[".$arrPartes."]";
	
	$consulta="SELECT cveEstado,estado FROM 820_estados ORDER BY estado";
	$arrEstados=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idTipoTelefono,tipoTelefono FROM 1006_tipoTelefono";
	$arrTelefonos=$con->obtenerFilasArreglo($consulta);
?>
var arrTelefonos=<?php echo $arrTelefonos?>;
var arrEstados=<?php echo $arrEstados?>;
var arrStatusParte=[['0','Baja'],['1','Alta']];
var selPersona='';
var arrParteProcesal=[<?php echo $arrParteProcesal?>];
var listParteProcesal='<?php echo $listParteProcesal?>';
var nodoSujetoSel=null;

  
Ext.onReady(inicializar);

function inicializar()
{
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                border:false,
                                                items:	[
                                                            crearPanelPartesProcesales()
                                                        ]
                                            }
                                         ]
                            }
                        )   
}

function crearPanelPartesProcesales()
{
	var cmbDetalle_P=crearComboExt('cmbDetalle_P',[],200,5,150);
	if(cmbDetalle_P.getStore().getCount()==0)
    	cmbDetalle_P.hide();
    
    var cmbNacionalidad_P=crearComboExt('cmbNacionalidad_P',arrNacionalidadesCP,160,65,200);
    cmbNacionalidad_P.hide();
    
    cmbNacionalidad_P.on('select',function(cmb,registro)				
    							{
                                	if(registro.data.id=='77777')
                                    {
                                    	gEx('lblNacionalidadEspecifique_P').show();
                                        gEx('txtOtraNacionalidad_P').show();
                                    }
                                    else
                                    {
                                    	gEx('lblNacionalidadEspecifique_P').hide();
                                        gEx('txtOtraNacionalidad_P').hide();
                                        gEx('txtOtraNacionalidad_P').setValue('');
                                    }
                                }
    				)
    var cmbGenero_P=crearComboExt('cmbGenero_P',arrGeneroCP,95,155,130);
    var cmbEstadoCivil_P=crearComboExt('cmbEstadoCivil_P',arrEstadoCivilCP,95,185,135);
    
    var cmbIdentificacion_P=crearComboExt('cmbIdentificacion_P',arrTipoIdentificacionCP,420,185,280);
    
    cmbIdentificacion_P.on('select',function(cmb,registro)					
    								{
                                    	if(registro.data.id=='99')
                                        {
                                        	gEx('txtEspecifique_P').show();
                                        	gEx('txtEspecifique_P').focus(10,false);
                                        }
                                        else
                                        {
                                        	gEx('txtEspecifique_P').setValue('');
                                        	gEx('txtEspecifique_P').hide();
                                        	
                                        }
                                    }
    						)
        
	var cmbEstado=crearComboExt('cmbEstado',arrEstados,70,65,170);
    cmbEstado.on('select',obtenerMunicipios);
    var cmbMunicipio=crearComboExt('cmbMunicipio',[],320,65,180);
	var panel= new Ext.Panel	(
    								{
                                    	layout:'border',
                                        region:'center',
                                        border:false,
                                        items:	[
                                        			{
                                                        xtype:'panel',
                                                        layout:'border',
                                                        region:'west',
                                                        width:250,
                                                        title:'Partes procesales',
                                                        items:	[
                                                                    crearArbolSujetosProcesalesAdmon()
                                                                ]
                                                    },
                                                    {
                                                        xtype:'panel',
                                                        layout:'border',
                                                        region:'center',
                                                        items:	[
                                                        			{	
                                                                    	xtype:'panel',
                                                                    	region:'center',
                                                                        defaultType: 'label',
                                                                        layout:'absolute',
                                                                        baseCls: 'x-plain',
                                                                        bodyStyle:{"font: normal 11px tahoma,arial,helvetica,sans-serif;background-color":"#E8E8E8","font-size":"11px"},                                                                                                           
                                                                        items:	[
                                                                        			{
                                                                                    	xtype:'tabpanel',
                                                                                        activeTab:1,
                                                                                        height:300,
                                                                                        id:'panelGenerales',
                                                                                        baseCls: 'x-plain',
                                                                        				tbar:	[
                                                                                                    {
                                                                                                        icon:'../images/guardar.JPG',
                                                                                                        cls:'x-btn-text-icon',
                                                                                                        disabled:true,
                                                                                                        id:'btnGuardarIdentificacion',
                                                                                                        text:'Guardar datos de identificacion',
                                                                                                        handler:function()
                                                                                                                {
                                                                                                                    guardarDatosIdentificacion();
                                                                                                                }
                                                                                                        
                                                                                                    }
                                                                                                ],
                                                                                        region:'center',
                                                                                        items:	[
                                                                                        			{
                                                                                                    	xtype:'panel',
                                                                                                        baseCls: 'x-plain',
                                                                                                        id:'panelIdentificacion',
                                                                                                        disabled:true,
                                                                                                        listeners:	{
                                                                                                                        show:function(p)
                                                                                                                                {
                                                                                                                                    if(!p.disabled)
                                                                                                                                        gEx('btnGuardarIdentificacion').enable();
                                                                                                                                    
                                                                                                                                    
                                                                                                                                }
                                                                                                                    },
                                                                                                        title:'Datos de identificaci&oacute;n',
                                                                                                        defaultType: 'label',
                                                                                                        layout:'absolute',
                                                                                                        items:	[
                                                                                                        			{
                                                                                                                        x:10,
                                                                                                                        y:10,
                                                                                                                        html:'<b><span style="color:#900" id="lblNombreTipo_P"></span></b>'
                                                                                                                    },
                                                                                                                    cmbDetalle_P,
                                                                                                                    {
                                                                                                                        x:380,
                                                                                                                        y:10,
                                                                                                                        html:'Tipo de persona:'
                                                                                                                    },
                                                                                                                    {
                                                                                                                        xtype:'radio',
                                                                                                                        x:570,
                                                                                                                        y:5,
                                                                                                                        id: 'tipoPersona_1_P',
                                                                                                                        name: 'tipoPersona',
                                                                                                                        inputValue: 1,
                                                                                                                        checked:true,
                                                                                                                        listeners:	{
                                                                                                                                        check:tipoPersonaCheckPanel
                                                                                                                                    },
                                                                                                                        boxLabel: 'F&iacute;sica'
                                                                                                                    }, 
                                                                                                                    {
                                                                                                                        xtype:'radio',
                                                                                                                        x:670,
                                                                                                                        y:5,
                                                                                                                        id: 'tipoPersona_2_P',
                                                                                                                        name: 'tipoPersona',
                                                                                                                        inputValue: 2,
                                                                                                                        listeners:	{
                                                                                                                                        check:tipoPersonaCheckPanel
                                                                                                                                    },
                                                                                                                        boxLabel: 'Moral'
                                                                                                                    },
                                                                                                                    {
                                                                                                                        x:10,
                                                                                                                        y:40,
                                                                                                                        id:'lblNacionalidad_P',
                                                                                                                        html:'¿Es de nacionalidad mexicana?:'
                                                                                                                    },
                                                                                                                    {
                                                                                                                        xtype:'radio',
                                                                                                                        checked:true,
                                                                                                                        name:'nacionalidad',
                                                                                                                        id: 'nacionalidad_1_P',
                                                                                                                        inputValue: 1,
                                                                                                                        x:200,
                                                                                                                        y:35,
                                                                                                                        listeners:	{
                                                                                                                                        check:tipoNacionalidadCheckPanel
                                                                                                                                    },
                                                                                                                        boxLabel: 'S&iacute;'
                                                                                                                    }, 
                                                                                                                    {	
                                                                                                                        xtype:'radio',
                                                                                                                        name:'nacionalidad',
                                                                                                                        id: 'nacionalidad_0_P',
                                                                                                                        inputValue: 0,
                                                                                                                        x:300,
                                                                                                                        y:35,
                                                                                                                        listeners:	{
                                                                                                                                        check:tipoNacionalidadCheckPanel
                                                                                                                                    },
                                                                                                                        boxLabel: 'No'
                                                                                                                    }, 
                                                                                                                    {
                                                                                                                        xtype:'radio',
                                                                                                                        name:'nacionalidad',
                                                                                                                        id: 'nacionalidad_2_P',
                                                                                                                        inputValue: 2,
                                                                                                                        x:380,
                                                                                                                        y:35,
                                                                                                                        listeners:	{
                                                                                                                                        check:tipoNacionalidadCheckPanel
                                                                                                                                    },
                                                                                                                        boxLabel: 'Mexicana / Otro'
                                                                                                                    }, 
                                                                                                                    {
                                                                                                                        xtype:'radio',
                                                                                                                        name:'nacionalidad',
                                                                                                                        id: 'nacionalidad_3_P',
                                                                                                                        inputValue: 3,
                                                                                                                        x:520,
                                                                                                                        y:35,
                                                                                                                        listeners:	{
                                                                                                                                        check:tipoNacionalidadCheckPanel
                                                                                                                                    },
                                                                                                                        boxLabel: 'No especificada'
                                                                                                                    },
                                                                                                                    {
                                                                                                                        x:10,
                                                                                                                        y:70,
                                                                                                                        hidden:true,
                                                                                                                        id:'lblNacionalidadIndique_P',
                                                                                                                        html:'Indique la nacionalidad:'
                                                                                                                    },
                                                                                                                    cmbNacionalidad_P,
                                                                                                                    {
                                                                                                                        x:380,
                                                                                                                        y:70,
                                                                                                                        hidden:true,
                                                                                                                        id:'lblNacionalidadEspecifique_P',
                                                                                                                        html:'Especifique:'
                                                                                                                    },
                                                                                                                    {
                                                                                                                        x:490,
                                                                                                                        y:65,
                                                                                                                        hidden:true,
                                                                                                                        width:200,
                                                                                                                        xtype:'textfield',
                                                                                                                        id:'txtOtraNacionalidad_P'
                                                                                                                    },
                                                                                                                    {
                                                                                                                        x:10,
                                                                                                                        y:100,
                                                                                                                        hidden:<?php echo $tipoMateria=="P"?"false":"true"?>,
                                                                                                                        id:'lblRFC_P',
                                                                                                                        html:'RFC:'
                                                                                                                    },
                                                                                                                    {
                                                                                                                        x:95,
                                                                                                                        y:95,
                                                                                                                        hidden:<?php echo $tipoMateria=="P"?"false":"true"?>,
                                                                                                                        xtype:'textfield',
                                                                                                                        id:'txtRFC_P',
                                                                                                                        width:145,
                                                                                                                        enableKeyEvents:true,
                                                                                                                        listeners:	{
                                                                                                                                        keypress:function(txt,e)
                                                                                                                                            {
                                                                                                                                                if(e.charCode=='13')
                                                                                                                                                {
                                                                                                                                                    if(txt.ultimaBusqueda!=txt.getValue())
                                                                                                                                                    {
                                                                                                                                                        //buscarPorRFC(txt.getValue());
                                                                                                                                                    }
                                                                                                                                                }
                                                                                                                                            },
                                                                                                                                        blur:function(txt)
                                                                                                                                            {
                                                                                                                                                
                                                                                                                                                if(txt.ultimaBusqueda!=txt.getValue())
                                                                                                                                                {
                                                                                                                                                    //buscarPorRFC(txt.getValue());
                                                                                                                                                }
                                                                                                                                                
                                                                                                                                            }
                                                                                                                                    }
                                                                                                                    },
                                                                                                                    {
                                                                                                                        x:255,
                                                                                                                        y:100,
                                                                                                                        hidden:<?php echo $tipoMateria=="P"?"false":"true"?>,
                                                                                                                        id:'lblCURP',
                                                                                                                        html:'CURP:'
                                                                                                                    },
                                                                                                                    {
                                                                                                                        x:350,
                                                                                                                        y:95,
                                                                                                                        hidden:<?php echo $tipoMateria=="P"?"false":"true"?>,
                                                                                                                        xtype:'textfield',
                                                                                                                        id:'txtCURP_P',
                                                                                                                        width:170
                                                                                                                    },
                                                                                                                    {
                                                                                                                        x:<?php echo $tipoMateria=="P"?"535":"10"?>,
                                                                                                                        y:100,
                                                                                                                        id:'lblCedula_P',
                                                                                                                        html:'<?php echo $tipoMateria=="P"?"C&eacute;dula profesional:":"C&eacute;d. Prof.:"?>',
                                                                                                                    },
                                                                                                                    {
                                                                                                                        x:<?php echo $tipoMateria=="P"?"680":"95"?>,
                                                                                                                        y:95,
                                                                                                                        xtype:'numberfield',
                                                                                                                        allowDecimals:false,
                                                                                                                        allowNegative:false,
                                                                                                                        id:'txtCedula_P',
                                                                                                                        
                                                                                                                        width:110,
                                                                                                                        enableKeyEvents:true,
                                                                                                                        listeners:	{
                                                                                                                                        keypress:function(txt,e)
                                                                                                                                            {
                                                                                                                                                if(e.charCode=='13')
                                                                                                                                                {
                                                                                                                                                    if(txt.ultimaBusqueda!=txt.getValue())
                                                                                                                                                    {
                                                                                                                                                        //buscarCedulaProfesional(txt.getValue());
                                                                                                                                                    }
                                                                                                                                                }
                                                                                                                                            },
                                                                                                                                        blur:function(txt)
                                                                                                                                            {
                                                                                                                                                
                                                                                                                                                if(txt.ultimaBusqueda!=txt.getValue())
                                                                                                                                                {
                                                                                                                                                    //buscarCedulaProfesional(txt.getValue());
                                                                                                                                                }
                                                                                                                                                
                                                                                                                                            }
                                                                                                                                    }
                                                                                                                    },
                                                                                                                    {
                                                                                                                        x:10,
                                                                                                                        y:130,
                                                                                                                        id:'lblNombre_P',
                                                                                                                        html:'Nombre: <span style="color:#F00">*</span>'
                                                                                                                    },
                                                                                                                    {
                                                                                                                        xtype:'textfield',
                                                                                                                        width:145,
                                                                                                                        id:'txtNombre_P',
                                                                                                                        x:95,
                                                                                                                        y:125
                                                                                                                    },
                                                                                                                    {
                                                                                                                        xtype:'textfield',
                                                                                                                        width:650,
                                                                                                                        hidden:true,
                                                                                                                        id:'txtRazonSocial_P',
                                                                                                                        x:115,
                                                                                                                        y:125
                                                                                                                    },
                                                                                                                    {
                                                                                                                        x:255,
                                                                                                                        y:130,
                                                                                                                        id:'lblApPaterno_P',
                                                                                                                        html:'Ap. Paterno: <span style="color:#F00">*</span>'
                                                                                                                    },
                                                                                                                    {
                                                                                                                        xtype:'textfield',
                                                                                                                        width:110,
                                                                                                                        id:'txtApPaterno_P',
                                                                                                                        x:350,
                                                                                                                        y:125
                                                                                                                    },
                                                                                                                    {
                                                                                                                        x:535,
                                                                                                                        y:130,
                                                                                                                        id:'lblApMaterno_P',
                                                                                                                        html:'Ap. Materno:'
                                                                                                                    },
                                                                                                                    {
                                                                                                                        xtype:'textfield',
                                                                                                                        width:110,
                                                                                                                        id:'txtApMaterno_P',
                                                                                                                        x:680,
                                                                                                                        y:125
                                                                                                                    },
                                                                                                                    {
                                                                                                                        x:10,
                                                                                                                        y:160,
                                                                                                                        id:'lblGenero_P',
                                                                                                                        html:'G&eacute;nero: <span style="color:#F00">*</span>'
                                                                                                                    },
                                                                                                                    cmbGenero_P,
                                                                                                                    {
                                                                                                                        x:255,
                                                                                                                        y:160,
                                                                                                                        id:'lblFechaNac_P',
                                                                                                                        html:'Fecha Nac.:'
                                                                                                                    },
                                                                                                                    {
                                                                                                                        x:335,
                                                                                                                        y:155,
                                                                                                                        xtype:'datefield',
                                                                                                                        id:'fechaNacimiento_P',
                                                                                                                        listeners:	{
                                                                                                                        				select:function(dte)
                                                                                                                                        		{
                                                                                                                                                	var edad=calcularEdadParticipante(dte.getValue());
                                                                                                                                                    gEx('txtEdad_P').setValue(edad);
                                                                                                                                                }
                                                                                                                        			}
                                                                                                                    },
                                                                                                                    {
                                                                                                                        x:460,
                                                                                                                        y:160,
                                                                                                                        id:'lblEdad_P',
                                                                                                                        html:'Edad:'
                                                                                                                    },
                                                                                                                    {
                                                                                                                        xtype:'numberfield',
                                                                                                                        width:60,
                                                                                                                        x:540,
                                                                                                                        y:155,
                                                                                                                        id:'txtEdad_P'
                                                                                                                    },
                                                                                                                    {
                                                                                                                        x:10,
                                                                                                                        y:190,
                                                                                                                        id:'lblEdoCivil_P',
                                                                                                                        html:'Estado civil:'
                                                                                                                    },
                                                                                                                    cmbEstadoCivil_P,
                                                                                                                    {
                                                                                                                        x:255,
                                                                                                                        y:190,
                                                                                                                        id:'lblIdentificacion_P',
                                                                                                                        xtype:'label',
                                                                                                                        html:'Identificaci&oacute;n presentada:'
                                                        
                                                                                                                        
                                                                                                                    },
                                                                                                                    cmbIdentificacion_P,
                                                                                                                    
                                                                                                                    {
                                                                                                                        xtype:'textfield',
                                                                                                                        x:710,
                                                                                                                        y:185,
                                                                                                                        hidden:true,
                                                                                                                        id:'txtEspecifique_P',
                                                                                                                        widht:250
                                                                                                                    }
                                                                                                        		]
                                                                                                    },
                                                                                                    crearGridAliasPanel()
                                                                                        		]
                                                                                    }
                                                                        		]
                                                                    },
                                                        			{
                                                                        id:'pContacto',
                                                                        xtype:'panel',
                                                                        collapsible:true,
                                                                        region:'south',
                                                                        height:250,
                                                                        title:'Datos de contacto',
                                                                        layout:'border',
                                                                        items:	[
                                                                                    {
                                                                                          xtype:'tabpanel',
                                                                                          id:'panelContacto',
                                                                                          activeTab:1,
                                                                                          disabled:true,
                                                                                          region:'center',  
                                                                                          tbar:	[
                                                                                                    {
                                                                                                        icon:'../images/guardar.JPG',
                                                                                                        cls:'x-btn-text-icon',
                                                                                                        text:'Guardar datos de contacto',
                                                                                                        handler:function()
                                                                                                                {
                                                                                                                    guardarDatosContacto();
                                                                                                                }
                                                                                                        
                                                                                                    }
                                                                                                ],                                                                                
                                                                                          items:	[
                                                                                                      {
                                                                                                          xtype:'panel',
                                                                                                          id:'pDomicilio',
                                                                                                          layout:'absolute',
                                                                                                          title:'Domicilio',
                                                                                                          bodyStyle:{"background-color":"#E8E8E8","font-size":"11px"}, 
                                                                                                          defaultType: 'label',
                                                                                                          items:	[
                                                                                                                      {
                                                                                                                          x:10,
                                                                                                                          y:10,
                                                                                                                          html:'Calle:'
                                                                                                                      },
                                                                                                                      {
                                                                                                                          x:70,
                                                                                                                          y:5,
                                                                                                                          xtype:'textfield',
                                                                                                                          width:410,
                                                                                                                          id:'txtCalle'
                                                                                                                      },
                                                                                                                      {
                                                                                                                          x:510,
                                                                                                                          y:10,
                                                                                                                          html:'No. Ext:'
                                                                                                                      },
                                                                                                                      {
                                                                                                                          x:590,
                                                                                                                          y:5,
                                                                                                                          xtype:'textfield',
                                                                                                                          width:120,
                                                                                                                          id:'txtNoExt'
                                                                                                                      },
                                                                                                                      {
                                                                                                                          x:10,
                                                                                                                          y:40,
                                                                                                                          html:'No. Int:'
                                                                                                                      },
                                                                                                                      {
                                                                                                                          x:70,
                                                                                                                          y:35,
                                                                                                                          xtype:'textfield',
                                                                                                                          width:120,
                                                                                                                          id:'txtNoInt'
                                                                                                                      },
                                                                                                                      {
                                                                                                                          x:250,
                                                                                                                          y:40,
                                                                                                                          html:'Colonia:'
                                                                                                                      },
                                                                                                                      {
                                                                                                                          x:320,
                                                                                                                          y:35,
                                                                                                                          xtype:'textfield',
                                                                                                                          width:160,
                                                                                                                          id:'txtColonia'
                                                                                                                      },
                                                                                                                      {
                                                                                                                          x:510,
                                                                                                                          y:40,
                                                                                                                          html:'C.P.:'
                                                                                                                      },
                                                                                                                      {
                                                                                                                          x:590,
                                                                                                                          y:35,
                                                                                                                          xtype:'textfield',
                                                                                                                          width:100,
                                                                                                                          id:'txtCP'
                                                                                                                      },
                                                                                                                      {
                                                                                                                          x:10,
                                                                                                                          y:70,
                                                                                                                          html:'Estado:'
                                                                                                                      },
                                                                                                                      cmbEstado,
                                                                                                                      
                                                                                                                      {
                                                                                                                          x:250,
                                                                                                                          y:70,
                                                                                                                          html:'Municipio:'
                                                                                                                      },
                                                                                                                     cmbMunicipio,
                                                                                                                      {
                                                                                                                          x:510,
                                                                                                                          y:70,
                                                                                                                          html:'Localidad:'
                                                                                                                      },
                                                                                                                      {
                                                                                                                          x:590,
                                                                                                                          y:65,
                                                                                                                          xtype:'textfield',
                                                                                                                          width:160,
                                                                                                                          id:'txtLocalidad'
                                                                                                                      },
                                                                                                                      {
                                                                                                                          x:10,
                                                                                                                          y:100,
                                                                                                                          html:'Entre la calle:'
                                                                                                                      },
                                                                                                                      {
                                                                                                                          x:105,
                                                                                                                          y:95,
                                                                                                                          xtype:'textfield',
                                                                                                                          width:270,
                                                                                                                          id:'txtEntreCalle'
                                                                                                                      },
                                                                                                                      {
                                                                                                                          x:395,
                                                                                                                          y:100,
                                                                                                                          html:'y la calle:'
                                                                                                                      },
                                                                                                                      {
                                                                                                                          x:470,
                                                                                                                          y:95,
                                                                                                                          xtype:'textfield',
                                                                                                                          width:280,
                                                                                                                          id:'txtYCalle'
                                                                                                                      },
                                                                                                                      {
                                                                                                                          x:10,
                                                                                                                          y:130,
                                                                                                                          html:'Otras referencias:'
                                                                                                                      },
                                                                                                                      {
                                                                                                                          x:130,
                                                                                                                          y:125,
                                                                                                                          xtype:'textarea',
                                                                                                                          width:620,
                                                                                                                          height:35,
                                                                                                                          id:'txtReferencias'
                                                                                                                      }
                                                                                                                  ]
                                                                                                      },
                                                                                                      {
                                                                                                          xtype:'panel',
                                                                                                          layout:'absolute',
                                                                                                          id:'pMail',
                                                                                                          title:'Correo electr&oacute;nico - Tel&eacute;fonos',
                                                                                                          bodyStyle:{"background-color":"#E8E8E8","font-size":"11px"}, 
                                                                                                          defaultType: 'label',
                                                                                                          items:	[
                                                                                                                        crearGridTelefono(),
                                                                                                                        crearGridMail()
                                                                                                                    ]
                                                                                                      }
                                                                                                  ]
                                                                                      }
                                                                                ]
                                                                    }
                                                                ]
                                                    }
                                        		]
                                    }
    							)
	
    gEx('panelGenerales').setActiveTab(0);
    gEx('panelContacto').setActiveTab(0);
    return panel;   
}

function crearArbolSujetosProcesalesAdmon()
{
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
                                                                    iC:gE('idCarpetaAdministrativa').value,
                                                                    cA:gE('carpetaAdministrativa').value,
                                                                    iA:gE('idActividad').value,
                                                                    sujetosProcesales:listParteProcesal
                                                                },
                                                    dataUrl:'../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php'
                                                }
                                            )		
										
	cargadorArbol.on('beforeload',function(c)
    						{
                            	nodoSujetoSel=null;
                                gEx('btnDelParticipante').disable();
                                gEx('btnAddRelacion').disable();
                                gEx('btnDelRelacion').disable();
                                gEx('btnActivateParticipante').disable();
                                gEx('btnActivateRelacion').disable();
                                gEx('btnHistorialPartes').disable();
                               
                            }
    				)	
    										
	cargadorArbol.on('load',function(c,nodoCarga)
    						{
                            	if(selPersona!='')
                                {
                                	var nodo=gEx('arbolSujetosAdmon').getNodeById(selPersona);
                                    gEx('arbolSujetosAdmon').getSelectionModel().select(nodo);
                                    funcSujeto(nodo);
                                }
                            }
    				)										
	var arbolSujetosJuridicos=new Ext.tree.TreePanel	(
                                                            {
                                                                id:'arbolSujetosAdmon',
                                                                useArrows:true,
                                                                animate:true,
                                                                enableDD:false,
                                                                ddScroll:true,
                                                                containerScroll: true,
                                                                autoScroll:true,
                                                                border:false,
                                                                region:'center',
                                                                root:raiz,
                                                                loader: cargadorArbol,
                                                                rootVisible:false,
                                                                tbar:	[
                                                                			{
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Agregar parte...',
                                                                                menu:	<?php echo $arrPartes?>
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/cog.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Otras acciones...',
                                                                                menu:	[
                                                                                			{
                                                                                                icon:'../images/accept_green.png',
                                                                                                cls:'x-btn-text-icon',
                                                                                                id:'btnActivateParticipante',
                                                                                                disabled:true,
                                                                                                text:'Dar de alta participante',
                                                                                                handler:function()
                                                                                                        {
                                                                                                            mostrarVentanaModificarStatusParticipante(1,1);
                                                                                                        }
                                                                                                
                                                                                            },
                                                                                			{
                                                                                                icon:'../images/cancel_round.png',
                                                                                                cls:'x-btn-text-icon',
                                                                                                id:'btnDelParticipante',
                                                                                                disabled:true,
                                                                                                text:'Dar de baja participante',
                                                                                                handler:function()
                                                                                                        {
                                                                                                            mostrarVentanaModificarStatusParticipante(1,0);
                                                                                                        }
                                                                                                
                                                                                            }
                                                                                            ,'-',
                                                                                            {
                                                                                                icon:'../images/bullet_green.png',
                                                                                                cls:'x-btn-text-icon',
                                                                                                id:'btnActivateRelacion',
                                                                                                disabled:true,
                                                                                                text:'Dar de alta relaci&oacute;n',
                                                                                                handler:function()
                                                                                                        {
                                                                                                            mostrarVentanaModificarStatusParticipante(2,1);
                                                                                                        }
                                                                                                
                                                                                            },
                                                                                            {
                                                                                                icon:'../images/bullet_red.png',
                                                                                                cls:'x-btn-text-icon',
                                                                                                id:'btnDelRelacion',
                                                                                                disabled:true,
                                                                                                text:'Dar de baja la relaci&oacute;n',
                                                                                                handler:function()
                                                                                                        {
                                                                                                            mostrarVentanaModificarStatusParticipante(2,0);
                                                                                                        }
                                                                                                
                                                                                            },'-',
                                                                                            {
                                                                                                icon:'../images/user_add.png',
                                                                                                cls:'x-btn-text-icon',
                                                                                                id:'btnAddRelacion',
                                                                                                disabled:true,
                                                                                                text:'Agregar nueva relaci&oacute;n',
                                                                                                handler:function()
                                                                                                        {
                                                                                                            mostrarVentanaAgregarRelacionParticipante();
                                                                                                        }
                                                                                                
                                                                                            },'-',
                                                                                            {
                                                                                                icon:'../images/report.png',
                                                                                                cls:'x-btn-text-icon',
                                                                                                id:'btnHistorialPartes',
                                                                                                disabled:true,
                                                                                                text:'Ver historial',
                                                                                                handler:function()
                                                                                                        {
                                                                                                            verHistorialParte();
                                                                                                        }
                                                                                                
                                                                                            }
                                                                                			
                                                                                		]
                                                                                
                                                                            }
                                                                            
                                                                		]
                                                            }
                                                        )
         
         
                                                    
	arbolSujetosJuridicos.on('click',funcSujeto);
	return  arbolSujetosJuridicos;
}

function funcSujeto(nodo, evento)
{
	nodoSujetoSel=nodo;
	gEx('btnDelParticipante').disable();
    gEx('btnAddRelacion').disable();
    gEx('btnDelRelacion').disable();
    gEx('btnActivateParticipante').disable();
    gEx('btnActivateRelacion').disable();
    
    if(nodo.attributes.tipo=='1')
    {
    	var arrDatosNodo=nodo.id.split('_');
        idParticipanteSel=arrDatosNodo[1];
        obtenerDatosContacto(idParticipanteSel);
        obtenerDatosIdentificacion(idParticipanteSel);
        gEx('panelContacto').enable();
        if(nodo.attributes.situacion=='1')
	        gEx('btnDelParticipante').enable();
        else
        	gEx('btnActivateParticipante').enable()
        
        var pos=existeValorMatriz(arrParteProcesal,nodo.attributes.personaJuridica);

        if((arrParteProcesal[pos][3].length>0)&&(nodo.attributes.situacion=='1'))
	        gEx('btnAddRelacion').enable();
        
        gEx('btnHistorialPartes').enable();

        
    }
    else
    {
    	if(nodo.attributes.tipo=='5')
        {
        	if(nodo.attributes.situacion=='1')
	        	gEx('btnDelRelacion').enable();
            else
            	gEx('btnActivateRelacion').enable();
                
            gEx('btnHistorialPartes').enable();
        }
        limpiarDatosIdentificacion();
    	limpiarDatosContacto();
        gEx('panelGenerales').setActiveTab(0);
        gEx('panelIdentificacion').disable();
        gEx('btnGuardarIdentificacion').disable();
        gEx('gAliasPanel').disable();
        gEx('panelContacto').disable();
        
    }
    
    
}


function crearGridTelefono()
{
	var cmbTipoTelefono=crearComboExt('cmbTipoTelefono',arrTelefonos);
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'tipoTelefono'},
                                                                    {name: 'lada'},
                                                                    {name: 'numero'},
                                                                    {name: 'extension'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	
														chkRow,
														{
															header:'Tipo',
															width:100,
															sortable:true,
															dataIndex:'tipoTelefono',
                                                            editor:cmbTipoTelefono,
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrTelefonos,val);
                                                                    }
														},
														{
															header:'Lada',
															width:45,
															sortable:true,
															dataIndex:'lada',
                                                            editor:	{
                                                            			xtype:'textfield'
                                                            		}
														},
                                                        {
															header:'N&uacute;mero',
															width:130,
															sortable:true,
															dataIndex:'numero',
                                                            editor:	{
                                                            			xtype:'textfield'
                                                            		}
														},
                                                        {
															header:'Extensi&oacute;n',
															width:80,
															sortable:true,
															dataIndex:'extension',
                                                            editor:	{
                                                            			xtype:'numberfield',
                                                                        allowDecimals:false,
                                                                        allowNegative:false
                                                            		}
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gTelefonos',
                                                            store:alDatos,
                                                            frame:false,
                                                            border:true,
                                                            x:10,
                                                            y:10,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,                                                            
                                                            columnLines : true,
                                                            height:150,
                                                            width:420,
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
                                                                                                                        {name: 'numero'},
                                                                                                                        {name: 'extension'}
                                                                                                                    ]
                                                                                        						)
                                                                                   		var r=new reg	(
                                                                                        					{
                                                                                                            	tipoTelefono:'1',
                                                                                                                lada:'',
                                                                                                                numero:'',
                                                                                                                extension:''
                                                                                                            }
                                                                                        				)
                                                                                   
                                                                                    	gEx('gTelefonos').getStore().add(r);
                                                                                        gEx('gTelefonos').startEditing(gEx('gTelefonos').getStore().getCount()-1,1);
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover tel&eacute;fono',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=gEx('gTelefonos').getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el tel&eacute;fono a remover');
                                                                                        	return;
                                                                                        }
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	gEx('gTelefonos').getStore().remove(fila);
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el tel&eacute;fono seleccionado?',resp);
                                                                                       
                                                                                        
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;	
}

function crearGridMail()
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
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	chkRow,
                                                        {
															header:'E-Mail',
															width:250,
															sortable:true,
															dataIndex:'mail',
                                                            editor:	{
                                                            			xtype:'textfield'
                                                            		}
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gMail',
                                                            store:alDatos,
                                                            frame:false,
                                                            border:true,
                                                            x:440,
                                                            y:10,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,                                                            
                                                            columnLines : true,
                                                            height:150,
                                                            width:300,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar E-Mail',
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
                                                                                   
                                                                                    	gEx('gMail').getStore().add(r);
                                                                                        gEx('gMail').startEditing(gEx('gMail').getStore().getCount()-1,1);
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover E-Mail',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=gEx('gMail').getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar la direcci&oacute;n de e-mail a remover');
                                                                                        	return;
                                                                                        }
                                                                                        
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	gEx('gMail').getStore().remove(fila);
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el e-mail seleccionado?',resp);
                                                                                       
                                                                                        
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;	
}

function obtenerDatosContacto(idParticipanteContacto)
{

	function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	limpiarDatosContacto();
        	oDatosContacto=eval('['+arrResp[1]+']')[0];

        	var telefonos='';
            var x;
            var o;
            var e;
            if(oDatosContacto.telefonos.length>0)
            {
            	for(x=0;x<oDatosContacto.telefonos.length;x++)	
                {
                	o=oDatosContacto.telefonos[x];
                	var reg=crearRegistro	(
                                                [
                                                    {name: 'tipoTelefono'},
                                                    {name: 'lada'},
                                                    {name: 'numero'},
                                                    {name: 'extension'}
                                                ]
                                            )
                    var r=new reg	(
                                        {
                                            tipoTelefono:o.tipoTelefono,
                                            lada:o.lada,
                                            numero:o.numero,
                                            extension:o.extension
                                        }
                                    )
               
                    gEx('gTelefonos').getStore().add(r);
                
                
                	
                    
                }
                
            }
            
            var email='';
            
            if(oDatosContacto.correos.length>0)
            {
            	
            	for(x=0;x<oDatosContacto.correos.length;x++)	
                {
                	o=oDatosContacto.correos[x];
                    var reg=crearRegistro	(
                                                [
                                                    {name: 'mail'}
                                                ]
                                            )
                    var r=new reg	(
                                        {
                                            mail:o.mail
                                        }
                                    )
               
                    gEx('gMail').getStore().add(r);
                }

            }
            
            gEx('txtCalle').setValue(oDatosContacto.calle);
            gEx('txtNoExt').setValue(oDatosContacto.noExt);
            gEx('txtNoInt').setValue(oDatosContacto.noInt);
            gEx('txtColonia').setValue(oDatosContacto.colonia);
            gEx('txtCP').setValue(oDatosContacto.cp);
			gEx('cmbEstado').setValue(oDatosContacto.estado);
            var pos=obtenerPosFila(gEx('cmbEstado').getStore(),'id',oDatosContacto.estado);
            if(pos>-1)
            {
                var registro=gEx('cmbEstado').getStore().getAt(pos);
                obtenerMunicipios(gEx('cmbEstado'),registro,function()
                                                {
                                                    gEx('cmbMunicipio').setValue(oDatosContacto.municipio);
                                                }
                                    )
                
			}            
            gEx('txtLocalidad').setValue(oDatosContacto.localidad);
            gEx('txtEntreCalle').setValue(oDatosContacto.entreCalle);
            gEx('txtYCalle').setValue(oDatosContacto.yCalle);
            gEx('txtReferencias').setValue(escaparBR(oDatosContacto.referencias));
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=116&idParticipante='+idParticipanteContacto,true);


	
}


function limpiarDatosContacto()
{
	gEx('txtCalle').setValue('');
    gEx('txtNoExt').setValue('');
    gEx('txtNoInt').setValue('');
    gEx('txtColonia').setValue('');
    gEx('txtCP').setValue('');
    gEx('txtCalle').setValue('');
    
    gEx('cmbEstado').setValue('');
    gEx('cmbMunicipio').setValue('');
    gEx('txtLocalidad').setValue('');
    gEx('txtEntreCalle').setValue('');
    gEx('txtYCalle').setValue('');
    gEx('txtReferencias').setValue('');
    gEx('gTelefonos').getStore().removeAll();
    gEx('gMail').getStore().removeAll();
}

function guardarDatosContacto()
{
	var txtCalle=gEx('txtCalle');
    var txtNoExt=gEx('txtNoExt');
    var txtNoInt=gEx('txtNoInt');
    var txtColonia=gEx('txtColonia');
    var txtCP=gEx('txtCP');
    var txtLocalidad=gEx('txtLocalidad');
    var txtEntreCalle=gEx('txtEntreCalle');
    var txtYCalle=gEx('txtYCalle');
    var txtReferencias=gEx('txtReferencias');
    var cmbEstado=gEx('cmbEstado');
    var cmbMunicipio=gEx('cmbMunicipio');
    
    var arrTelefonos='';
    
    var x;
    var fila;
    var o;
    for(x=0;x<gEx('gTelefonos').getStore().getCount();x++)
    {
        fila=gEx('gTelefonos').getStore().getAt(x);
        
        if(fila.data.numero=='')
        {
            function respTel()
            {
                gEx('gTelefonos').startEditing(x,3);
            }
            msgBox('Debe ingresar el n&uacute;mero telef&oacute;nico a agregar',respTel);
            return;
        }
        
        o='{"tipoTelefono":"'+fila.data.tipoTelefono+'","lada":"'+fila.data.lada+
            '","numero":"'+fila.data.numero+'","extension":"'+fila.data.extension+'"}';
        if(arrTelefonos=='')
            arrTelefonos=o;
        else
            arrTelefonos+=','+o;
    }
    
    var arrMail='';
    
    for(x=0;x<gEx('gMail').getStore().getCount();x++)
    {
        fila=gEx('gMail').getStore().getAt(x);
        if(!validarCorreo(fila.data.mail))
        {
            function respMail()
            {
                gEx('gMail').startEditing(x,1);
            }
            msgBox('El e-mail ingresado no es v&aacute;lido',respMail);
            return;
        }
        o='{"mail":"'+fila.data.mail+'"}';
        if(arrMail=='')
            arrMail=o;
        else
            arrMail+=','+o;
    }
    
    
    var cadObj='{"calle":"'+cv(txtCalle.getValue())+'","noExt":"'+cv(txtNoExt.getValue())+
                '","noInt":"'+cv(txtNoInt.getValue())+'","colonia":"'+cv(txtColonia.getValue())+
                '","cp":"'+cv(txtCP.getValue())+'","estado":"'+cmbEstado.getValue()+
                '","municipio":"'+cmbMunicipio.getValue()+'","localidad":"'+cv(txtLocalidad.getValue())+
                '","entreCalle":"'+cv(txtEntreCalle.getValue())+'","yCalle":"'+cv(txtYCalle.getValue())+
                '","referencias":"'+cv(txtReferencias.getValue())+'","arrTelefonos":['+arrTelefonos+
                '],"mail":['+arrMail+'],"idFormulario":"-47",'+
                '"idRegistro":"-1","idParticipante":"'+idParticipanteSel+'"}';
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            msgBox('La informaci&oacute;n ha sido almacenada correctamente');
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=117&cadObj='+cadObj,true);
    
}

function obtenerDatosIdentificacion(idParticipanteContacto)
{
	function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	limpiarDatosIdentificacion();
        	var oDatos=eval(arrResp[1])[0];
			if(oDatos.tipoPersona=='')
            	oDatos.tipoPersona='1';
            gE('lblNombreTipo_P').innerHTML=formatearValorRenderer(arrParteProcesal,nodoSujetoSel.attributes.personaJuridica);
            
            var pos=existeValorMatriz(arrParteProcesal,nodoSujetoSel.attributes.personaJuridica);
            var cmbDetalle_P=gEx('cmbDetalle_P');
            cmbDetalle_P.getStore().loadData(arrParteProcesal[pos][2]);
            cmbDetalle_P.setValue(oDatos.detalleTipo);
            if(cmbDetalle_P.getStore().getCount()==0)
                cmbDetalle_P.hide();
            else
            	cmbDetalle_P.show();
            
            
            gEx('tipoPersona_'+oDatos.tipoPersona+'_P').setValue(true);
            tipoPersonaCheckPanel(gEx('tipoPersona_'+oDatos.tipoPersona+'_P'),true);
            gEx('nacionalidad_'+oDatos.esMexicano+'_P').setValue(true);
            tipoNacionalidadCheckPanel(gEx('nacionalidad_'+oDatos.esMexicano+'_P'),true);
            gEx('cmbNacionalidad_P').setValue(oDatos.nacionalidad);
            dispararEventoSelectCombo('cmbNacionalidad_P');
            gEx('txtOtraNacionalidad_P').setValue(oDatos.otraNacionalidad);
            
            gEx('txtRFC_P').setValue(oDatos.rfcEmpresa);
            gEx('txtCURP_P').setValue(oDatos.curp);
            gEx('txtCedula_P').setValue(oDatos.cedulaProfesional);
            
            gEx('txtNombre_P').setValue(oDatos.nombre);
            gEx('txtRazonSocial_P').setValue(oDatos.nombre);
            gEx('txtApPaterno_P').setValue(oDatos.apellidoPaterno);
            gEx('txtApMaterno_P').setValue(oDatos.apellidoMaterno);
            
            
            gEx('cmbGenero_P').setValue(oDatos.genero);
            gEx('fechaNacimiento_P').setValue(oDatos.fechaNacimiento);
            gEx('txtEdad_P').setValue(oDatos.edad);
            gEx('cmbEstadoCivil_P').setValue(oDatos.estadoCivil);
            gEx('cmbIdentificacion_P').setValue(oDatos.tipoIdentificacion);
            dispararEventoSelectCombo('cmbIdentificacion_P');
            gEx('txtEspecifique_P').setValue(oDatos.otraIdentificacion);
          
          	var x;
            var r;
            var reg=new crearRegistro	(	
            								[
                                                {name: 'nombre'},
                                                {name: 'apPaterno'},
                                                {name: 'apMaterno'}
                                            ]
            							);
            for(x=0;x<oDatos.alias.length;x++)
            {
            	r=new reg(oDatos.alias[x]);
            	gEx('gAliasPanel').getStore().add(r);
            }
            if(gEx('panelGenerales').getActiveTab().id!='gCuentasUsuario')
	            gEx('btnGuardarIdentificacion').enable();
            gEx('panelIdentificacion').enable();
            gEx('gAliasPanel').enable();
            
        	
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=210&idActividad='+gE('idActividad').value+
    				'&figuraJuridica='+nodoSujetoSel.attributes.personaJuridica+'&idParticipante='+idParticipanteContacto,true);

}

function guardarDatosIdentificacion()
{
	
	var cmbDetalle=gEx('cmbDetalle_P');
    
	if(cmbDetalle.getStore().getCount()>0)
    {
        if(cmbDetalle.getValue()=='')
        {
            function resp301()
            {
                cmbDetalle.focus();
            }
            msgBox('Debe indicar el "tipo" del participante',resp301);
            return;
        }
        
    }
    
    var personaMoral=gEx('tipoPersona_2_P').getValue();
    
    var cadObj='';
    if(personaMoral)
    {
        if((gEx('txtRFC_P').getValue()!='')&&(gEx('txtRFC_P').getValue().length!=12))
        {
            function respRFC()
            {
                gEx('txtRFC_P').focus();
            }
            msgBox('La logitud del RFC debe ser de 12 caracteres',respRFC);
            return;
        }
        
        if(gEx('txtRazonSocial_P').getValue()=='')
        {
            function resp30()
            {
                gEx('txtRazonSocial_P').focus();
            }
            msgBox('Debe indicar la raz&oacute;n social de la persona moral',resp30);
            return;
        }
        
       cadObj='{"detallePersona":"'+cmbDetalle.getValue()+
                '","tipoPersona":"2","nombre":"'+cv(gEx('txtRazonSocial_P').getValue())+
                '","apPaterno":"","apMaterno":"","genero":"2","otraNacionalidad":"","nacionalidadMexicana":"3",'+
                '"nacionalidad":"","alias":[],"curp":"'+cv(gEx('txtCURP_P').getValue())+'","cedulaProfesional":"'+cv(gEx('txtCedula_P').getValue())+
                '","rfc":"'+cv(gEx('txtRFC_P').getValue())+'","fechaNacimiento":"'+
                (gEx('fechaNacimiento_P').getValue()==''?'':gEx('fechaNacimiento_P').getValue().format('Y-m-d'))+
                '","edad":"'+gEx('txtEdad_P').getValue()+'","estadoCivil":"'+gEx('cmbEstadoCivil_P').getValue()+
                '","identificacionPresentada":"'+gEx('cmbIdentificacion_P').getValue()+'","otraIdentificacion":"'+
                cv(gEx('txtEspecifique_P').getValue())+'","idPersona":"'+nodoSujetoSel.attributes.idPersona+'"}';
    }
    else
    {
        
        if(gEx('nacionalidad_0_P').getValue() || gEx('nacionalidad_2_P').getValue())
        {
            if(gEx('cmbNacionalidad_P').getValue()=='')
            {
                function resp1()
                {
                    gEx('cmbNacionalidad_P').focus();
                }
                msgBox('Debe indicar la nacionalidad de la persona f&iacute;sica',resp1);
                return;
            }
            
            if(gEx('cmbNacionalidad_P').getValue()=='77777')
            {
                if(gEx('txtOtraNacionalidad_P').getValue()=='')
                {
                    function resp2()
                    {
                        gEx('txtOtraNacionalidad_P').focus();
                    }
                    msgBox('Debe indicar la nacionalidad de la persona f&iacute;sica',resp2);
                    return;
                }
            }
        }
                           
        if((gEx('txtCURP_P').getValue()!='')&&(gEx('txtCURP_P').getValue().length!=18))
        {
            function respCURP()
            {
                gEx('txtCURP_P').focus();
            }
            msgBox('La logitud de la CURP debe ser de 18 caracteres',respCURP);
            return;
        }                   
                                                                                    
        if((gEx('txtRFC_P').getValue()!='')&&(gEx('txtRFC_P').getValue().length!=13))
        {
            function respRFC()
            {
                gEx('txtRFC_P').focus();
            }
            msgBox('La logitud del RFC debe ser de 13 caracteres',respRFC);
            return;
        }
        
        
        
        if(gEx('txtNombre_P').getValue()=='')
        {
            function resp3()
            {
                gEx('txtNombre_P').focus();
            }
            msgBox('Debe indicar el nombre de la persona f&iacute;sica',resp3);
            return;
        }
        
        if(gEx('txtApPaterno_P').getValue()=='')
        {
            function resp3AP()
            {
                gEx('txtApPaterno_P').focus();
            }
            msgBox('Debe indicar el apellido paterno de la persona f&iacute;sica',resp3AP);
            return;
        }
        
        if(gEx('cmbGenero_P').getValue()=='')
        {
            function resp4()
            {
                gEx('cmbGenero_P').focus();
            }
            msgBox('Debe indicar el g&eacute;nero de la persona f&iacute;sica',resp4);
            return;
        }
        
        var fila;
        var gAlias=gEx('gAliasPanel');
        var arrAlias='';
        var x=0;
        var o;
        for(x=0;x<gAlias.getStore().getCount();x++)
        {
            fila=gAlias.getStore().getAt(x);
            if((fila.data.nombre.trim()!='')||(fila.data.apPaterno.trim()!='')||(fila.data.apMaterno.trim()!=''))
            {
            
                o='{"nombre":"'+cv(fila.data.nombre)+'","apPaterno":"'+cv(fila.data.apPaterno)+'","apMaterno":"'+cv(fila.data.apMaterno)+'"}';
                if(arrAlias=='')
                    arrAlias=o;
                else
                    arrAlias+=','+o;
            }                                                                           
        }
        
        var nacionalidadMexicana='';
        
        if(gEx('nacionalidad_0_P').getValue())
        {
            nacionalidadMexicana=0;
        }
        
        if(gEx('nacionalidad_1_P').getValue())
        {
            nacionalidadMexicana=1;
        }
        
        if(gEx('nacionalidad_2_P').getValue())
        {
            nacionalidadMexicana=2;
        }
        
        if(gEx('nacionalidad_3_P').getValue())
        {
            nacionalidadMexicana=3;
        }
        
        
        cadObj='{"tipoPersona":"1","nombre":"'+cv(gEx('txtNombre_P').getValue())+'","apPaterno":"'+cv(gEx('txtApPaterno_P').getValue())+
                '","apMaterno":"'+cv(gEx('txtApMaterno_P').getValue())+'","nacionalidadMexicana":"'+nacionalidadMexicana+
                '","nacionalidad":"'+gEx('cmbNacionalidad_P').getValue()+'","otraNacionalidad":"'+cv(gEx('txtOtraNacionalidad_P').getValue())+
                '","genero":"'+gEx('cmbGenero_P').getValue()+'","alias":['+arrAlias+'],"detallePersona":"'+cmbDetalle.getValue()+
                '","curp":"'+cv(gEx('txtCURP_P').getValue())+'","cedulaProfesional":"'+cv(gEx('txtCedula_P').getValue())+
                '","rfc":"'+cv(gEx('txtRFC_P').getValue())+'","fechaNacimiento":"'+
                (gEx('fechaNacimiento_P').getValue()==''?'':gEx('fechaNacimiento_P').getValue().format('Y-m-d'))+
                '","edad":"'+gEx('txtEdad_P').getValue()+'","estadoCivil":"'+gEx('cmbEstadoCivil_P').getValue()+
                '","identificacionPresentada":"'+gEx('cmbIdentificacion_P').getValue()+'","otraIdentificacion":"'+
                cv(gEx('txtEspecifique_P').getValue())+'","idPersona":"'+nodoSujetoSel.attributes.idPersona+'"}';
    }
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            recargarArbolParticipantes(nodoSujetoSel.attributes.idPersona,'',nodoSujetoSel.attributes.personaJuridica);
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax, 'POST','funcion=32&cadObj='+cadObj,true);
}

function limpiarDatosIdentificacion()
{
	gEx('tipoPersona_1_P').setValue(true);
    tipoPersonaCheckPanel(gEx('tipoPersona_1_P'),true);
	gEx('nacionalidad_1_P').setValue(true);
    tipoNacionalidadCheckPanel(gEx('nacionalidad_1_P'),true);
    
    gEx('cmbNacionalidad_P').setValue('');
    gEx('txtOtraNacionalidad_P').setValue('');
    gEx('txtRFC_P').setValue('');
    gEx('txtCURP_P').setValue('');
    gEx('txtCedula_P').setValue('');
    gEx('txtNombre_P').setValue('');
    gEx('txtRazonSocial_P').setValue('');
    gEx('txtApPaterno_P').setValue('');
    gEx('txtApMaterno_P').setValue('');
    gEx('cmbGenero_P').setValue('');
    gEx('fechaNacimiento_P').setValue('');
    gEx('txtEdad_P').setValue('');
    gEx('cmbEstadoCivil_P').setValue('');
    gEx('cmbIdentificacion_P').setValue('');
    gEx('txtEspecifique_P').setValue('');
    gEx('txtEspecifique_P').hide();
    
  	gEx('gAliasPanel').getStore().removeAll();
    
}

function recargarArbolParticipantes(iP,n,tP)
{
	selPersona='p_'+iP+'_'+tP;
	gEx('arbolSujetosAdmon').getRootNode().reload();

}

function tipoPersonaCheckPanel(rdo,value)
{
	if(value)
    {
		switch(rdo.id)
        {
        	case 'tipoPersona_1_P':
            	gEx('lblNacionalidadIndique_P').hide();
                gEx('cmbNacionalidad_P').hide();
                gEx('cmbNacionalidad_P').setValue('');
                gEx('lblNacionalidadEspecifique_P').hide();
                gEx('txtOtraNacionalidad_P').hide();
                gEx('txtOtraNacionalidad_P').setValue('');
            	gEx('lblNombre_P').setText('Nombre: <span style="color:#F00">*</span>',false);
                gEx('txtRazonSocial_P').setValue('');
                gEx('txtRazonSocial_P').hide();
                
            	gEx('lblNacionalidad_P').show();
                gEx('nacionalidad_0_P').show();
                gEx('nacionalidad_1_P').show();
                gEx('nacionalidad_2_P').show();
                gEx('nacionalidad_3_P').show();
                gEx('txtNombre_P').show();
                gEx('txtApPaterno_P').show();
                gEx('txtApMaterno_P').show();
                gEx('lblApPaterno_P').show();
                gEx('lblApMaterno_P').show();
                gEx('lblGenero_P').show();
                gEx('cmbGenero_P').show();
                
                gEx('txtRFC_P').setPosition(95,95);
				
                gEx('lblCedula_P').show();
                gEx('txtCedula_P').show();
            
                gEx('lblCURP').show();
                gEx('txtCURP_P').show();
            
                gEx('lblFechaNac_P').show();
                gEx('fechaNacimiento_P').show();
            
                gEx('lblEdad_P').show();
                gEx('txtEdad_P').show();
            
                gEx('lblEdoCivil_P').show();
                gEx('cmbEstadoCivil_P').show();
            
                gEx('lblIdentificacion_P').show();
                gEx('cmbIdentificacion_P').show();
                gEx('txtEspecifique_P').show();
				                
            break;
            case 'tipoPersona_2_P':
            	gEx('lblNacionalidadIndique_P').hide();
                gEx('cmbNacionalidad_P').hide();
                gEx('cmbNacionalidad_P').setValue('');
                gEx('lblNacionalidadEspecifique_P').hide();
                gEx('txtOtraNacionalidad_P').hide();
                gEx('txtOtraNacionalidad_P').setValue('');
	            gEx('txtRazonSocial_P').show();
                gEx('txtRazonSocial_P').focus();
            	gEx('lblNombre_P').setText('Raz&oacute;n social: <span style="color:#F00">*</span>',false);
            	gEx('lblNacionalidad_P').hide();
                gEx('nacionalidad_0_P').hide();
                gEx('nacionalidad_1_P').hide();
                gEx('nacionalidad_2_P').hide();
                gEx('nacionalidad_3_P').hide();
                
                gEx('txtNombre_P').hide();
                gEx('txtApPaterno_P').hide();
                gEx('txtApMaterno_P').hide();
                
                gEx('txtNombre_P').setValue('');
                gEx('txtApPaterno_P').setValue('');
                gEx('txtApMaterno_P').setValue('');
                gEx('cmbGenero_P').setValue('');
                
                gEx('lblApPaterno_P').hide();
                gEx('lblApMaterno_P').hide();
                gEx('lblGenero_P').hide();
                gEx('cmbGenero_P').hide();
                gEx('txtRFC_P').setPosition(115,95);
                gEx('lblCedula_P').hide();
                gEx('txtCedula_P').hide();
                gEx('txtCedula_P').setValue('');
                gEx('lblCURP').hide();
                gEx('txtCURP_P').hide();
                gEx('txtCURP_P').setValue('');
                
                gEx('lblFechaNac_P').hide();
                gEx('fechaNacimiento_P').hide();
                gEx('fechaNacimiento_P').setValue('');
                gEx('lblEdad_P').hide();
                gEx('txtEdad_P').hide();
                gEx('txtEdad_P').setValue('');
                gEx('lblEdoCivil_P').hide();
                gEx('cmbEstadoCivil_P').hide();
                gEx('cmbEstadoCivil_P').setValue('');
                gEx('lblIdentificacion_P').hide();
                gEx('cmbIdentificacion_P').hide();
                gEx('cmbIdentificacion_P').setValue('');
                gEx('txtEspecifique_P').hide();
                gEx('txtEspecifique_P').setValue('');
                
            break;
            
        }
    }
}

function tipoNacionalidadCheckPanel(rdo,value)
{
	if(value)
    {
    	switch(rdo.id)
        {
        	case 'nacionalidad_0_P':
            case 'nacionalidad_2_P':
            	gEx('lblNacionalidadIndique_P').show();
                gEx('cmbNacionalidad_P').show();
            break;
            case 'nacionalidad_1_P':
            case 'nacionalidad_3_P':
            	gEx('lblNacionalidadIndique_P').hide();
                gEx('cmbNacionalidad_P').hide();
                gEx('lblNacionalidadEspecifique_P').hide();
                gEx('txtOtraNacionalidad_P').hide();
                gEx('txtOtraNacionalidad_P').setValue('');
                gEx('cmbNacionalidad_P').setValue('');
            break;
            
           
        }
    }
}

function crearGridAliasPanel()
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
                                                        	id:'gAliasPanel',
                                                            store:alDatos,
                                                            frame:false,
                                                            disabled:true,
                                                            title:'Registro de alias',
                                                            x:10,
                                                            y:190,
                                                            listeners:	{
                                                            				show:function(p)
                                                                            		{
                                                                                    	if(!p.disabled)
	                                                                                        gEx('btnGuardarIdentificacion').enable();
                                                                                    	setTimeout(function()
                                                                                        			{
                                                                                                    	gEx('gAliasPanel').getView().refresh();
                                                                                                    },500
                                                                                                    )
                                                                                    	
                                                                                    }
                                                            			},
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
                                                                                    
                                                                                    	gEx('gAliasPanel').getStore().add(r);
                                                                                        gEx('gAliasPanel').startEditing(gEx('gAliasPanel').getStore().getCount()-1,1);
                                                                                        
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover alias',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=gEx('gAliasPanel').getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el alias que desea remover');
                                                                                            return;
                                                                                        }
                                                                                        
                                                                                       gEx('gAliasPanel').getStore().remove(fila); 
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;		
}

function obtenerMunicipios(cmb,registro,funcAfterLoad)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var arrDatos=eval(arrResp[1]);
            gEx('cmbMunicipio').setValue('');
            gEx('cmbMunicipio').getStore().loadData(arrDatos);
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

function mostrarVentanaModificarStatusParticipante(tipoAccion,situacion)
{
	var leyenda='';
    var leyendaConfirmacion;
    var leyendaError='';

	switch(tipoAccion)
    {
    	case 1:
        	switch(situacion)
            {
            	case 1:
                	leyenda='Dar de alta participante ['+nodoSujetoSel.attributes.nombre+']';
                    leyendaConfirmacion=' dar de alta al participante: <b>'+nodoSujetoSel.attributes.nombre+'</b>';
                    
                break;
                case 0:
                	leyenda='Dar de baja participante ['+nodoSujetoSel.attributes.nombre+']';
                    leyendaConfirmacion=' dar de baja al participante: <b>'+nodoSujetoSel.attributes.nombre+'</b>';
                break;
            }
        break;
        case 2:
        	switch(situacion)
            {
            	case 1:
                	leyenda='Dar de alta relaci&oacute;n ['+nodoSujetoSel.parentNode.attributes.nombre+' --> '+nodoSujetoSel.attributes.nombre+']';
                    leyendaConfirmacion=' dar de alta la relaci&oacute;n <b>'+nodoSujetoSel.parentNode.attributes.nombre+' --> '+nodoSujetoSel.attributes.nombre+'</b>';
                break;
                case 0:
                	leyenda='Dar de baja relaci&oacute;n  ['+nodoSujetoSel.parentNode.attributes.nombre+' --> '+nodoSujetoSel.attributes.nombre+']';
                    leyendaConfirmacion=' dar de baja la relaci&oacute;n <b>'+nodoSujetoSel.parentNode.attributes.nombre+' --> '+nodoSujetoSel.attributes.nombre+'</b>';
                break;
            }
        
        break;
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
                                                            html:'Ingrese el motivo de la operaci&oacute;n:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            width:550,
                                                            heght:60,
                                                            id:'txtComentariosAdicionales',
                                                            xtype:'textarea'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: leyenda,
										width: 600,
										height:200,
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
                                                                	gEx('txtComentariosAdicionales').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var txtComentariosAdicionales=gEx('txtComentariosAdicionales');
                                                                        if(txtComentariosAdicionales.getValue()=='')
                                                                        {
                                                                            function respComentarios()
                                                                            {
                                                                                txtComentariosAdicionales.focus(false,500);
                                                                            }
                                                                            msgBox('Debe indicar el motivo de la operaci&oacute;n',respComentarios);
                                                                            return;
                                                                        }
                                                                        
																		function resp(btn)
                                                                        {
                                                                            if(btn=='yes')
                                                                            {
                                                                            	var idParticipante;
                                                                                var idFiguraJuridica;
                                                                                var idActorRelacionado;
                                                                                
                                                                                if(tipoAccion==1)
                                                                                {
                                                                                	idParticipante=nodoSujetoSel.attributes.idPersona;
                                                                                    idFiguraJuridica=nodoSujetoSel.attributes.personaJuridica;
                                                                                    idActorRelacionado=-1;
                                                                                }
                                                                                else
                                                                                {
                                                                                	idParticipante=nodoSujetoSel.parentNode.attributes.idPersona;
                                                                                    idFiguraJuridica=nodoSujetoSel.parentNode.attributes.personaJuridica;
                                                                                    idActorRelacionado=nodoSujetoSel.attributes.idPersona;
                                                                                }
                                                                                
                                                                                var cadObj='{"tipoAccion":"'+tipoAccion+'","situacion":"'+situacion+'","comentariosAdicionales":"'+
                                                                                		cv(gEx('txtComentariosAdicionales').getValue())+'","idActividad":"'+gE('idActividad').value+
                                                                                        '","idParticipante":"'+idParticipante+'","idFiguraJuridica":"'+idFiguraJuridica+
                                                                                        '","idActorRelacionado":"'+idActorRelacionado+'"}';
                                                                                
                                                                                function funcAjax()
                                                                                {
                                                                                    var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                        gEx('arbolSujetosAdmon').getRootNode().reload();
                                                                                        
                                                                                        ventanaAM.close();
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=215&cadObj='+cadObj,true);
                                                                            }
                                                                        }
                                                                        msgConfirm('Est&aacute; seguro de querer'+leyendaConfirmacion,resp);
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

function mostrarVentanaAgregarRelacionParticipante()
{
	var pos=existeValorMatriz(arrParteProcesal,nodoSujetoSel.attributes.personaJuridica);
	var listPartes='';
    var x;
    if(arrParteProcesal[pos][3]!='')
    {
    	var aFiguras=arrParteProcesal[pos][3].split(',');
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
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			crearArbolSujetosProcesalesRelacionSeleccionAlta(listPartes),
                                                        {
                                                        	x:10,
                                                            y:160,
                                                            html:'Comentarios adicionales:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:190,
                                                            xtype:'textarea',
                                                            width:660,
                                                            height:60,
                                                            id:'txtComentarios'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar nueva relaci&oacute;n',
										width: 720,
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
                                                                        
                                                                        if(listaRelacion=='')
                                                                        {
                                                                        	msgBox('Debe seleccionar almenos una persona a agregar como nueva relaci&oacute;n');
                                                                        	return;
                                                                        }
                                                                        var idParticipante=nodoSujetoSel.attributes.idPersona;
                                                                        var idFiguraJuridica=nodoSujetoSel.attributes.personaJuridica;
                                                                        var cadObj='{"comentariosAdicionales":"'+cv(gEx('txtComentarios').getValue())+'","idActividad":"'+gE('idActividad').value+
                                                                                        '","idParticipante":"'+idParticipante+'","idFiguraJuridica":"'+idFiguraJuridica+'","listaRelaciones":"'+listaRelacion+'"}';
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('arbolSujetosAdmon').getRootNode().reload();
                                                                                
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=216&cadObj='+cadObj,true);
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


function crearArbolSujetosProcesalesRelacionSeleccionAlta(listPartes)
{
	

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
                                                                    iC:gE('idCarpetaAdministrativa').value,
                                                                    cA:gE('carpetaAdministrativa').value,
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
                                                                        height:150,
                                                                        width:660,
                                                                        root:raiz,
                                                                        loader: cargadorArbol,
                                                                        rootVisible:false
                                                                    }
                                                                )
         
         
                                                    
	return  arbolSujetosRelacionSeleccion;
}

function verHistorialParte()
{
	var idParticipante='';
    var idFiguraJuridica='';
    var idActorRelacionado='';
    
	if(nodoSujetoSel.attributes.tipo=='1')
    {
        idParticipante=nodoSujetoSel.attributes.idPersona;
        idFiguraJuridica=nodoSujetoSel.attributes.personaJuridica;
        idActorRelacionado=-1;
    }
    else
    {
        idParticipante=nodoSujetoSel.parentNode.attributes.idPersona;
        idFiguraJuridica=nodoSujetoSel.parentNode.attributes.personaJuridica;
        idActorRelacionado=nodoSujetoSel.attributes.idPersona;
    }
    
    var cadObj='{"idActividad":"'+gE('idActividad').value+
                  '","idParticipante":"'+idParticipante+'","idFiguraJuridica":"'+idFiguraJuridica+
                  '","idActorRelacionado":"'+idActorRelacionado+'"}';

	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
                                            frame:false,
											defaultType: 'label',
											items: 	[
														crearGridHistorialParte(cadObj)

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Historial',
										width: 900,
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

function crearGridHistorialParte(cadObj)
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
                                                        {name:'fechaOperacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name:'etapaOriginal'},
		                                                {name:'etapaCambio'},
		                                                {name:'responsable'},
                                                        {name: 'comentariosAdicionales'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_SGP.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaOperacion', direction: 'DESC'},
                                                            groupField: 'fechaOperacion',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='217';
                                        proxy.baseParams.cadObj=cadObj;
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            {
                                                                header:'Fecha',
                                                                width:150,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'fechaOperacion',
                                                                renderer:function(val)
                                                                		{
                                                                        
                                                                        	return formatoTitulo(val.format('d')+' de '+arrMeses[parseInt(val.format('m'))-1][1]+' de '+val.format('Y')+'<br>('+val.format('H:i:s')+' hrs.)');
                                                                        }
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n anterior',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'etapaOriginal',
                                                                renderer:formatoTitulo2Parte
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n cambio',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'etapaCambio',
                                                                renderer:formatoTitulo2Parte
                                                            },                                                            
                                                            {
                                                                header:'Responsable',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'responsable',
                                                                renderer:formatoTitulo3
                                                            }
                                                            
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                    {
                                                        id:'gridHistorialParte',
                                                        store:alDatos,
                                                        region:'center',
                                                        frame:false,
                                                        border:true,
                                                        cm: cModelo,
                                                        columnLines : false,
                                                        stripeRows :true,
                                                        loadMask:true,
                                                                                                                        
                                                        view:new Ext.grid.GroupingView({
                                                                                            forceFit:false,
                                                                                            showGroupName: false,
                                                                                            enableGrouping :false,
                                                                                            enableNoGroups:false,
                                                                                            enableGroupingMenu:false,
                                                                                            hideGroupedColumn: false,
                                                                                            startCollapsed:false,
                                                                                            enableRowBody:true,
                                                                                            getRowClass : formatearFilaHistorial
                                                                                        })
                                                    }
                                                );
        return 	tblGrid;	

}

function formatoTitulo2Parte(val)
{
	return '<div style="font-size:11px; color:#040033;; height:45px; word-wrap: break-word;white-space: normal; ">'+formatearValorRenderer(arrStatusParte,val)+'</div>';
}

function formatoTitulo3(val)
{
	return '<div style="font-size:11px; height:45px; color:#040033; word-wrap: break-word;white-space: normal;"><img src="../images/user_gray.png">'+(val)+'</div>';
}

function formatearFilaHistorial(record, rowIndex, p, ds)
{
	var xf = Ext.util.Format;
    p.body = '<BR><p style="margin-left: 4em;margin-right: 4em;text-align:justify"><br><span class="menu"><span style="color: #001C02">Comentarios:</span><br><br><span style="color: #3B3C3B">' + ((record.data.comentariosAdicionales.trim()=="")?"(Sin comentarios)":record.data.comentariosAdicionales) + '</span></p><br><br><br>';
    return 'x-grid3-row-expanded';
}


function formatoTitulo(val)
{
	return '<span style="font-size:11px; color:#040033">'+val+'</span>';
}
