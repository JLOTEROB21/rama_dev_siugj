<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT idTipoTelefono,tipoTelefono FROM 1006_tipoTelefono";
	$arrTelefonosCParticipante=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__378_tablaDinamica,nacionalidad FROM _378_tablaDinamica WHERE id__378_tablaDinamica<>1 ORDER BY nacionalidad";
	$arrNacionalidades=$con->obtenerFilasArreglo($consulta);
	
	$listParteProcesal="";
	$consulta="SELECT id__5_tablaDinamica,
	if((SELECT nombreSingular FROM _5_aliasTiposFiguras WHERE idFigura=t.id__5_tablaDinamica AND materia='".$tipoMateria."') is null
			,nombreTipo,(SELECT nombreSingular FROM _5_aliasTiposFiguras WHERE idFigura=t.id__5_tablaDinamica AND materia='".$tipoMateria."')) as nombreTipo 
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
		$o="['".$filaFigura[0]."','".cv($filaFigura[1])."',".$arrDetalles.",'".$listFiguras."']";
		if($arrParteProcesal=="")
			$arrParteProcesal=$o;
		else
			$arrParteProcesal.=",".$o;
		
		
	}
	
	$consulta="SELECT idGenero,genero FROM 1005_generoUsuario";
	$arrGeneroCP=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__31_tablaDinamica,estadoCivil FROM _31_tablaDinamica";
	$arrEstadoCivil=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__32_tablaDinamica,LOWER(tipoIdentificacion) FROM _32_tablaDinamica WHERE id__32_tablaDinamica NOT IN(19,9999,13,17) ORDER BY tipoIdentificacion";
	$arrTipoIdentificacion=$con->obtenerFilasArreglo($consulta);
	$consulta="SELECT cveEstado,estado FROM 820_estados ORDER BY estado";
	$arrEstadosCParticipante=$con->obtenerFilasArreglo($consulta);
	
	
	
?>

var arrTelefonosCParticipante=<?php echo $arrTelefonosCParticipante?>;
var arrEstadosCParticipante=<?php echo $arrEstadosCParticipante?>;
var arrTipoIdentificacionCP=<?php echo $arrTipoIdentificacion ?>;
var arrEstadoCivilCP=<?php echo $arrEstadoCivil?>;
var arrGeneroCP=<?php echo $arrGeneroCP?>;
var arrParteProcesalCP=[<?php echo $arrParteProcesal ?>];
var arrNacionalidadesCP=<?php echo $arrNacionalidades?>;

if(typeof(arrParteProcesal)=='undefined')
{
	arrParteProcesal=arrParteProcesalCP;
}

function agregarParticipanteVentana(tipoParticipante,nombreTipo,objConf)
{
	var ajuste=0;
	if(objConf)
    {
    	if(objConf.ocultaCURP)
        {
        	ajuste+=30;
        }
        
        if((objConf.ocultaRFC)&&(objConf.ocultaCedula))
        {
        	ajuste+=30;
        }
        
        if((objConf.ocultaCURP)&&(objConf.ocultaRFC)&&(objConf.ocultaCedula))
        {
        	ajuste+=10;
        }
        
        
    }

	var nTipo='';
	
	pos=existeValorMatriz(arrParteProcesalCP,tipoParticipante);

	var listPartes='';
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
	nTipo=arrParteProcesalCP[pos][1];
	if(nombreTipo)
    {
    	nTipo=nombreTipo;
    }

	var cmbDetalle=crearComboExt('cmbDetalle',arrParteProcesalCP[pos][2],200,5,150);
	if(cmbDetalle.getStore().getCount()==0)
    	cmbDetalle.hide();
	var cmbNacionalidad=crearComboExt('cmbNacionalidad',arrNacionalidadesCP,160,95,200);
    cmbNacionalidad.hide();
    
    cmbNacionalidad.on('select',function(cmb,registro)				
    							{
                                	if(registro.data.id=='77777')
                                    {
                                    	gEx('lblNacionalidadEspecifique').show();
                                        gEx('txtOtraNacionalidad').show();
                                    }
                                    else
                                    {
                                    	gEx('lblNacionalidadEspecifique').hide();
                                        gEx('txtOtraNacionalidad').hide();
                                        gEx('txtOtraNacionalidad').setValue('');
                                    }
                                }
    				)
    
    
	var cmbGenero=crearComboExt('cmbGenero',arrGeneroCP,95,220-ajuste,130);
    var cmbEstadoCivil=crearComboExt('cmbEstadoCivil',arrEstadoCivilCP,95,250-ajuste,160);
    
    if(objConf && objConf.ocultaEdoCivil)
    {
    	cmbEstadoCivil.hide();
    }
    
    var cmbIdentificacion=crearComboExt('cmbIdentificacion',arrTipoIdentificacionCP,160,280-ajuste,300);
    if(objConf && objConf.ocultaIdentificacion)
    {
    	cmbIdentificacion.hide();
    }
    cmbIdentificacion.on('select',function(cmb,registro)					
    								{
                                    	if(registro.data.id=='99')
                                        {
                                        	gEx('txtEspecifique').show();
                                        	gEx('txtEspecifique').focus(10,false);
                                        }
                                        else
                                        {
                                        	gEx('txtEspecifique').setValue('');
                                        	gEx('txtEspecifique').hide();
                                        	
                                        }
                                    }
    						)
                            
                            
	var cmbEstadoCParticipante=crearComboExt('cmbEstadoCParticipante',arrEstadosCParticipante,70,65,170);
    cmbEstadoCParticipante.on('select',obtenerMunicipiosCParticipante);
    var cmbMunicipioCParticipante=crearComboExt('cmbMunicipioCParticipante',[],320,65,180);                            
                            
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	xtype:'tabpanel',
                                                            x:0,
                                                            y:0,
                                                            border:true,
                                                            baseCls: 'x-plain',
                                                            width:665,
                                                            height:430,
                                                            activeTab:0,
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
                                                                                            y:10,
                                                                                            html:'<span style="color:#900"><b>'+nombreTipo+(cmbDetalle.getStore().getCount()>0?':':'')+'</b></span>'
                                                                                        },
                                                                                        cmbDetalle,
                                                                                        {
                                                                                            x:10,
                                                                                            y:40,
                                                                                            html:'Tipo de persona:'
                                                                                        },
                                                                                        {
                                                                                            xtype:'radio',
                                                                                            x:200,
                                                                                            y:35,
                                                                                            id: 'tipoPersona_1',
                                                                                            name: 'tipoPersona',
                                                                                            inputValue: 1,
                                                                                            checked:true,
                                                                                            listeners:	{
                                                                                                            check:tipoPersonaCheckCP
                                                                                                        },
                                                                                            boxLabel: 'F&iacute;sica'
                                                                                        }, 
                                                                                        {
                                                                                            xtype:'radio',
                                                                                            x:300,
                                                                                            y:35,
                                                                                            id: 'tipoPersona_2',
                                                                                            name: 'tipoPersona',
                                                                                            inputValue: 2,
                                                                                            listeners:	{
                                                                                                            check:tipoPersonaCheckCP
                                                                                                        },
                                                                                            boxLabel: 'Moral'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:70,
                                                                                            id:'lblNacionalidad',
                                                                                            html:'¿Es de nacionalidad mexicana?:'
                                                                                        },
                                                                                        {
                                                                                            xtype:'radio',
                                                                                            checked:true,
                                                                                            name:'nacionalidad',
                                                                                            id: 'nacionalidad_1',
                                                                                            inputValue: 1,
                                                                                            x:200,
                                                                                            y:65,
                                                                                            listeners:	{
                                                                                                            check:tipoNacionalidadCheckCP
                                                                                                        },
                                                                                            boxLabel: 'S&iacute;'
                                                                                        }, 
                                                                                        {	
                                                                                            xtype:'radio',
                                                                                            name:'nacionalidad',
                                                                                            id: 'nacionalidad_0',
                                                                                            inputValue: 0,
                                                                                            x:300,
                                                                                            y:65,
                                                                                            listeners:	{
                                                                                                            check:tipoNacionalidadCheckCP
                                                                                                        },
                                                                                            boxLabel: 'No'
                                                                                        }, 
                                                                                        {
                                                                                            xtype:'radio',
                                                                                            name:'nacionalidad',
                                                                                            id: 'nacionalidad_2',
                                                                                            inputValue: 2,
                                                                                            x:380,
                                                                                            y:65,
                                                                                            listeners:	{
                                                                                                            check:tipoNacionalidadCheckCP
                                                                                                        },
                                                                                            boxLabel: 'Mexicana / Otro'
                                                                                        }, 
                                                                                        {
                                                                                            xtype:'radio',
                                                                                            name:'nacionalidad',
                                                                                            id: 'nacionalidad_3',
                                                                                            inputValue: 3,
                                                                                            x:520,
                                                                                            y:65,
                                                                                            listeners:	{
                                                                                                            check:tipoNacionalidadCheckCP
                                                                                                        },
                                                                                            boxLabel: 'No especificada'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:100,
                                                                                            hidden:true,
                                                                                            id:'lblNacionalidadIndique',
                                                                                            html:'Indique la nacionalidad:'
                                                                                        },
                                                                                        cmbNacionalidad,
                                                                                        {
                                                                                            x:380,
                                                                                            y:100,
                                                                                            hidden:true,
                                                                                            id:'lblNacionalidadEspecifique',
                                                                                            html:'Especifique:'
                                                                                        },
                                                                                        {
                                                                                            x:490,
                                                                                            y:95,
                                                                                            hidden:true,
                                                                                            width:200,
                                                                                            xtype:'textfield',
                                                                                            id:'txtOtraNacionalidad'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:130,
                                                                                            hidden:(objConf && objConf.ocultaCURP),
                                                                                            id:'lblCURP',
                                                                                            html:'CURP:'
                                                                                        },
                                                                                        {
                                                                                        	x:95,
                                                                                            y:125,
                                                                                            hidden:(objConf && objConf.ocultaCURP),
                                                                                            xtype:'textfield',
                                                                                            id:'txtCURP',
                                                                                            width:180,
                                                                                            enableKeyEvents:true,
                                                                                            listeners:	{
                                                                                                            keypress:function(txt,e)
                                                                                                                {
                                                                                                                    if(e.charCode=='13')
                                                                                                                    {
                                                                                                                        if(txt.ultimaBusqueda!=txt.getValue())
                                                                                                                        {
                                                                                                                            buscarPorCURP(txt.getValue());
                                                                                                                        }
                                                                                                                    }
                                                                                                                },
                                                                                                            blur:function(txt)
                                                                                                                {
                                                                                                                    
                                                                                                                    if(txt.ultimaBusqueda!=txt.getValue())
                                                                                                                    {
                                                                                                                        buscarPorCURP(txt.getValue());
                                                                                                                    }
                                                                                                                    
                                                                                                                }
                                                                                                        }
                                                                                        },
                                                                                        {
                                                                                            x:objConf.ocultaRFC?10:335,
                                                                                            y:155-ajuste,
                                                                                            hidden:(objConf && objConf.ocultaCedula),
                                                                                            id:'lblCedula',
                                                                                            html:objConf.ocultaRFC?'C&eacute;d. Prof.':'C&eacute;dula profesional:'
                                                                                        },
                                                                                        {
                                                                                        	x:objConf.ocultaRFC?95:460,
                                                                                            y:150-ajuste,
                                                                                            hidden:(objConf && objConf.ocultaCedula),
                                                                                            xtype:'numberfield',
                                                                                            allowDecimals:false,
                                                                                            allowNegative:false,
                                                                                            id:'txtCedula',                                                                                            
                                                                                            width:110,
                                                                                            enableKeyEvents:true,
                                                                                            listeners:	{
                                                                                                            keypress:function(txt,e)
                                                                                                                {
                                                                                                                    if(e.charCode=='13')
                                                                                                                    {
                                                                                                                        if(txt.ultimaBusqueda!=txt.getValue())
                                                                                                                        {
                                                                                                                            buscarCedulaProfesional(txt.getValue());
                                                                                                                        }
                                                                                                                    }
                                                                                                                },
                                                                                                            blur:function(txt)
                                                                                                                {
                                                                                                                    
                                                                                                                    if(txt.ultimaBusqueda!=txt.getValue())
                                                                                                                    {
                                                                                                                        buscarCedulaProfesional(txt.getValue());
                                                                                                                    }
                                                                                                                    
                                                                                                                }
                                                                                                        }
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:155-ajuste,
                                                                                            hidden:(objConf && objConf.ocultaRFC),
                                                                                            id:'lblRFC',
                                                                                            html:'RFC:'
                                                                                        },
                                                                                        {
                                                                                        	x:95,
                                                                                            y:150-ajuste,
                                                                                            hidden:(objConf && objConf.ocultaRFC),
                                                                                            xtype:'textfield',
                                                                                            id:'txtRFC',
                                                                                            width:145,
                                                                                            enableKeyEvents:true,
                                                                                            listeners:	{
                                                                                                            keypress:function(txt,e)
                                                                                                                {
                                                                                                                    if(e.charCode=='13')
                                                                                                                    {
                                                                                                                        if(txt.ultimaBusqueda!=txt.getValue())
                                                                                                                        {
                                                                                                                            buscarPorRFC(txt.getValue());
                                                                                                                        }
                                                                                                                    }
                                                                                                                },
                                                                                                            blur:function(txt)
                                                                                                                {
                                                                                                                    
                                                                                                                    if(txt.ultimaBusqueda!=txt.getValue())
                                                                                                                    {
                                                                                                                        buscarPorRFC(txt.getValue());
                                                                                                                    }
                                                                                                                    
                                                                                                                }
                                                                                                        }
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:195-ajuste,
                                                                                            id:'lblNombre',
                                                                                            html:'Nombre: <span style="color:#F00">*</span>'
                                                                                        },
                                                                                        {
                                                                                            xtype:'textfield',
                                                                                            width:145,
                                                                                            id:'txtNombre',
                                                                                            x:95,
                                                                                            y:190-ajuste
                                                                                        },
                                                                                        {
                                                                                            xtype:'textfield',
                                                                                            width:400,
                                                                                            hidden:true,
                                                                                            id:'txtRazonSocial',
                                                                                            x:115,
                                                                                            y:190-ajuste
                                                                                        },
                                                                                        {
                                                                                            x:255,
                                                                                            y:195-ajuste,
                                                                                            id:'lblApPaterno',
                                                                                            html:'Ap. Paterno: <span style="color:#F00">*</span>'
                                                                                        },
                                                                                        {
                                                                                            xtype:'textfield',
                                                                                            width:110,
                                                                                            id:'txtApPaterno',
                                                                                            x:335,
                                                                                            y:190-ajuste
                                                                                        },
                                                                                        {
                                                                                            x:460,
                                                                                            y:195-ajuste,
                                                                                            id:'lblApMaterno',
                                                                                            html:'Ap. Materno:'
                                                                                        },
                                                                                        {
                                                                                            xtype:'textfield',
                                                                                            width:110,
                                                                                            id:'txtApMaterno',
                                                                                            x:540,
                                                                                            y:190-ajuste
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:225-ajuste,
                                                                                            id:'lblGenero',
                                                                                            html:'G&eacute;nero: <span style="color:#F00">*</span>'
                                                                                        },
                                                                                        cmbGenero,
                                                                                        {
                                                                                            x:255,
                                                                                            y:225-ajuste,
                                                                                            hidden:(objConf && objConf.ocultaFechaNacimiento),
                                                                                            id:'lblFechaNac',
                                                                                            html:'Fecha Nac.:'
                                                                                        },
                                                                                        {
                                                                                        	x:335,
                                                                                            y:220-ajuste,
                                                                                            hidden:(objConf && objConf.ocultaFechaNacimiento),
                                                                                        	xtype:'datefield',
                                                                                            id:'fechaNacimiento',
                                                                                            listeners:	{
                                                                                                            change:function(dte)
                                                                                                                    {
                                                                                                                        var edad=calcularEdadParticipante(dte.getValue());
                                                                                                                        gEx('txtEdad').setValue(edad);
                                                                                                                    }
                                                                                                        }
                                                                                        },
                                                                                        {
                                                                                            x:460,
                                                                                            hidden:(objConf && objConf.ocultaEdad),
                                                                                            y:225-ajuste,
                                                                                            id:'lblEdad',
                                                                                            html:'Edad:'
                                                                                        },
                                                                                        {
                                                                                        	xtype:'numberfield',
                                                                                            width:60,
                                                                                            x:540,
                                                                                            hidden:(objConf && objConf.ocultaEdad),
                                                                                            y:220-ajuste,
                                                                                            id:'txtEdad'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:255-ajuste,
                                                                                            hidden:(objConf && objConf.ocultaEdoCivil),
                                                                                            id:'lblEdoCivil',
                                                                                            html:'Estado civil:'
                                                                                        },
                                                                                        cmbEstadoCivil,
                                                                                        {
                                                                                            x:10,
                                                                                            y:285-ajuste,
                                                                                            hidden:(objConf && objConf.ocultaIdentificacion),
                                                                                            id:'lblIdentificacion',
                                                                                            xtype:'label',
                                                                                            html:'Identificaci&oacute;n presentada:'
                            
                                                                                            
                                                                                        },
                                                                                        cmbIdentificacion,
                                                                                        
                                                                                        {
                                                                                            xtype:'textfield',
                                                                                            x:470,
                                                                                            hidden:true,
                                                                                            y:280-ajuste,
                                                                                            id:'txtEspecifique',
                                                                                            widht:300
                                                                                        }
                                                                            		]
                                                                        },
                                                                        crearGridAliasCP(),
                                                                        {
                                                                        	xtype:'panel',
                                                                            defaultType: 'label',
                                                                            layout:'border',
                                                                            baseCls: 'x-plain',
                                                                            title:'Datos de contacto',
                                                                            items:	[
                                                                                    	{
                                                                                              xtype:'tabpanel',
                                                                                              id:'panelContactoCParticipante',
                                                                                              activeTab:0,
                                                                                              
                                                                                              region:'center', 
                                                                                                                                                                             
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
                                                                                                                              id:'txtCalleCParticipante'
                                                                                                                          },
                                                                                                                          {
                                                                                                                              x:500,
                                                                                                                              y:10,
                                                                                                                              html:'No. Ext:'
                                                                                                                          },
                                                                                                                          {
                                                                                                                              x:560,
                                                                                                                              y:5,
                                                                                                                              xtype:'textfield',
                                                                                                                              width:95,
                                                                                                                              id:'txtNoExtCParticipante'
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
                                                                                                                              id:'txtNoIntCParticipante'
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
                                                                                                                              id:'txtColoniaCParticipante'
                                                                                                                          },
                                                                                                                          {
                                                                                                                              x:510,
                                                                                                                              y:40,
                                                                                                                              html:'C.P.:'
                                                                                                                          },
                                                                                                                          {
                                                                                                                              x:560,
                                                                                                                              y:35,
                                                                                                                              xtype:'textfield',
                                                                                                                              width:95,
                                                                                                                              id:'txtCPCParticipante'
                                                                                                                          },
                                                                                                                          {
                                                                                                                              x:10,
                                                                                                                              y:70,
                                                                                                                              html:'Estado:'
                                                                                                                          },
                                                                                                                          cmbEstadoCParticipante,
                                                                                                                          
                                                                                                                          {
                                                                                                                              x:250,
                                                                                                                              y:70,
                                                                                                                              html:'Municipio:'
                                                                                                                          },
                                                                                                                         cmbMunicipioCParticipante,
                                                                                                                          {
                                                                                                                              x:10,
                                                                                                                              y:100,
                                                                                                                              html:'Localidad:'
                                                                                                                          },
                                                                                                                          {
                                                                                                                              x:105,
                                                                                                                              y:95,
                                                                                                                              xtype:'textfield',
                                                                                                                              width:230,
                                                                                                                              id:'txtLocalidadCParticipante'
                                                                                                                          },
                                                                                                                          {
                                                                                                                              x:10,
                                                                                                                              y:130,
                                                                                                                              html:'Entre la calle:'
                                                                                                                          },
                                                                                                                          {
                                                                                                                              x:105,
                                                                                                                              y:125,
                                                                                                                              xtype:'textfield',
                                                                                                                              width:230,
                                                                                                                              id:'txtEntreCalleCParticipante'
                                                                                                                          },
                                                                                                                          {
                                                                                                                              x:355,
                                                                                                                              y:130,
                                                                                                                              html:'y la calle:'
                                                                                                                          },
                                                                                                                          {
                                                                                                                              x:430,
                                                                                                                              y:125,
                                                                                                                              xtype:'textfield',
                                                                                                                              width:230,
                                                                                                                              id:'txtYCalleCParticipante'
                                                                                                                          },
                                                                                                                          {
                                                                                                                              x:10,
                                                                                                                              y:160,
                                                                                                                              html:'Otras referencias:'
                                                                                                                          },
                                                                                                                          {
                                                                                                                              x:130,
                                                                                                                              y:155,
                                                                                                                              xtype:'textarea',
                                                                                                                              width:530,
                                                                                                                              height:35,
                                                                                                                              
                                                                                                                              id:'txtReferenciasCParticipante'
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
                                                                                                                            crearGridTelefonoCParticipante(),
                                                                                                                            crearGridMailCParticipante()
                                                                                                                        ]
                                                                                                          }
                                                                                                      ]
                                                                                          }
                                                                            		]
                                                                        }
                                                            		]
                                                        },
                                                        crearArbolSujetosProcesalesRelacion(listPartes,(objConf && objConf.idActividad)?objConf.idActividad:-1,(objConf && objConf.idParticipante)?objConf.idParticipante:-1)
                                            			
                                                        
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
                                    	id:'vParticipante',
										title: 'Agregar participante',
										width: 940,
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
                                                                	gEx('txtCURP').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',                                                            
															handler: function()
																	{
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
                                                                    	var personaMoral=gEx('tipoPersona_2').getValue();
                                                                        
																		var cadObj='';
                                                                        if(personaMoral)
                                                                        {
                                                                        	if((gEx('txtRFC').getValue()!='')&&(gEx('txtRFC').getValue().length!=12))
                                                                            {
                                                                            	function respRFC()
                                                                                {
                                                                                	gEx('txtRFC').focus();
                                                                                }
                                                                                msgBox('La logitud del RFC debe ser de 12 caracteres',respRFC);
                                                                                return;
                                                                            }
                                                                            
                                                                        	if(gEx('txtRazonSocial').getValue()=='')
                                                                            {
                                                                                function resp30()
                                                                                {
                                                                                    gEx('txtRazonSocial').focus();
                                                                                }
                                                                                msgBox('Debe indicar la raz&oacute;n social de la persona moral',resp30);
                                                                                return;
                                                                            }
                                                                            
                                                                           cadObj='{"datosContacto":@datosContacto,"detallePersona":"'+cmbDetalle.getValue()+
                                                                            		'","tipoPersona":"2","nombre":"'+cv(gEx('txtRazonSocial').getValue())+
                                                                                    '","apPaterno":"","apMaterno":"","genero":"2","otraNacionalidad":"","nacionalidadMexicana":"3",'+
                                                                                    '"nacionalidad":"","alias":[],"tipoFigura":"'+tipoParticipante+
                                                                                    '","curp":"'+cv(gEx('txtCURP').getValue())+'","cedulaProfesional":"'+cv(gEx('txtCedula').getValue())+
                                                                                    '","rfc":"'+cv(gEx('txtRFC').getValue())+'","fechaNacimiento":"'+
                                                                                    (gEx('fechaNacimiento').getValue()==''?'':gEx('fechaNacimiento').getValue().format('Y-m-d'))+
                                                                                    '","edad":"'+gEx('txtEdad').getValue()+'","estadoCivil":"'+gEx('cmbEstadoCivil').getValue()+
                                                                                    '","identificacionPresentada":"'+gEx('cmbIdentificacion').getValue()+'","otraIdentificacion":"'+
                                                                                    cv(gEx('txtEspecifique').getValue())+'","relacionadoCon":"'+listaRelacion+'"'+
                                                                                    ',"idActividad":"'+objConf.idActividad+'","idCarpeta":"'+objConf.idCarpeta+'"'+campoComp+'}';
                                                                        }
                                                                        else
                                                                        {
                                                                        	
                                                                            if(gEx('nacionalidad_0').getValue() || gEx('nacionalidad_2').getValue())
                                                                            {
                                                                            	if(gEx('cmbNacionalidad').getValue()=='')
                                                                                {
                                                                                	function resp1()
                                                                                    {
                                                                                    	gEx('cmbNacionalidad').focus();
                                                                                    }
                                                                                    msgBox('Debe indicar la nacionalidad de la persona f&iacute;sica',resp1);
                                                                                	return;
                                                                                }
                                                                                
                                                                                if(gEx('cmbNacionalidad').getValue()=='77777')
                                                                                {
                                                                                	if(gEx('txtOtraNacionalidad').getValue()=='')
                                                                                    {
                                                                                    	function resp2()
                                                                                        {
                                                                                            gEx('txtOtraNacionalidad').focus();
                                                                                        }
                                                                                        msgBox('Debe indicar la nacionalidad de la persona f&iacute;sica',resp2);
                                                                                        return;
                                                                                    }
                                                                                }
                                                                            }
                                                                                               
                                                                            if((gEx('txtCURP').getValue()!='')&&(gEx('txtCURP').getValue().length!=18))
                                                                            {
                                                                            	function respCURP()
                                                                                {
                                                                                	gEx('txtCURP').focus();
                                                                                }
                                                                                msgBox('La logitud de la CURP debe ser de 18 caracteres',respCURP);
                                                                                return;
                                                                            }                   
                                                                                                                                                        
                                                                            if((gEx('txtRFC').getValue()!='')&&(gEx('txtRFC').getValue().length!=13))
                                                                            {
                                                                            	function respRFC()
                                                                                {
                                                                                	gEx('txtRFC').focus();
                                                                                }
                                                                                msgBox('La logitud del RFC debe ser de 13 caracteres',respRFC);
                                                                                return;
                                                                            }
                                                                            
                                                                            
                                                                            
                                                                            if(gEx('txtNombre').getValue()=='')
                                                                            {
                                                                                function resp3()
                                                                                {
                                                                                    gEx('txtNombre').focus();
                                                                                }
                                                                                msgBox('Debe indicar el nombre de la persona f&iacute;sica',resp3);
                                                                                return;
                                                                            }
                                                                            
                                                                            if(gEx('txtApPaterno').getValue()=='')
                                                                            {
                                                                                function resp3AP()
                                                                                {
                                                                                    gEx('txtApPaterno').focus();
                                                                                }
                                                                                msgBox('Debe indicar el apellido paterno de la persona f&iacute;sica',resp3AP);
                                                                                return;
                                                                            }
                                                                            
                                                                            if(gEx('cmbGenero').getValue()=='')
                                                                            {
                                                                                function resp4()
                                                                                {
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
                                                                            
                                                                            if(gEx('nacionalidad_0').getValue())
                                                                            {
                                                                            	nacionalidadMexicana=0;
                                                                            }
                                                                            
                                                                            if(gEx('nacionalidad_1').getValue())
                                                                            {
                                                                            	nacionalidadMexicana=1;
                                                                            }
                                                                            
                                                                            if(gEx('nacionalidad_2').getValue())
                                                                            {
                                                                            	nacionalidadMexicana=2;
                                                                            }
                                                                            
                                                                            if(gEx('nacionalidad_3').getValue())
                                                                            {
                                                                            	nacionalidadMexicana=3;
                                                                            }
                                                                            
                                                                            
                                                                        	cadObj='{"datosContacto":@datosContacto,"tipoPersona":"1","nombre":"'+cv(gEx('txtNombre').getValue())+'","apPaterno":"'+cv(gEx('txtApPaterno').getValue())+
                                                                            		'","apMaterno":"'+cv(gEx('txtApMaterno').getValue())+'","nacionalidadMexicana":"'+nacionalidadMexicana+
                                                                                    '","nacionalidad":"'+gEx('cmbNacionalidad').getValue()+'","otraNacionalidad":"'+cv(gEx('txtOtraNacionalidad').getValue())+
                                                                                    '","genero":"'+gEx('cmbGenero').getValue()+'","alias":['+arrAlias+'],"detallePersona":"'+cmbDetalle.getValue()+
                                                                                    '","tipoFigura":"'+tipoParticipante+
                                                                                    '","curp":"'+cv(gEx('txtCURP').getValue())+'","cedulaProfesional":"'+cv(gEx('txtCedula').getValue())+
                                                                                    '","rfc":"'+cv(gEx('txtRFC').getValue())+'","fechaNacimiento":"'+
                                                                                    (gEx('fechaNacimiento').getValue()==''?'':gEx('fechaNacimiento').getValue().format('Y-m-d'))+
                                                                                    '","edad":"'+gEx('txtEdad').getValue()+'","estadoCivil":"'+gEx('cmbEstadoCivil').getValue()+
                                                                                    '","identificacionPresentada":"'+gEx('cmbIdentificacion').getValue()+'","otraIdentificacion":"'+
                                                                                    cv(gEx('txtEspecifique').getValue())+'","relacionadoCon":"'+listaRelacion+'"'+
                                                                                    ',"idActividad":"'+objConf.idActividad+'","idCarpeta":"'+objConf.idCarpeta+'"'+campoComp+'}';
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
                                                                        
                                                                        var x;
                                                                        var fila;
                                                                        var o;
                                                                        for(x=0;x<gEx('gTelefonosCParticipante').getStore().getCount();x++)
                                                                        {
                                                                            fila=gEx('gTelefonosCParticipante').getStore().getAt(x);
                                                                            
                                                                            if(fila.data.numero=='')
                                                                            {
                                                                                function respTel()
                                                                                {
                                                                                	gEx('panelContactoCParticipante').setActiveTab(1);
                                                                                    gEx('gTelefonosCParticipante').startEditing(x,3);
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
                                                                        
                                                                        for(x=0;x<gEx('gMailCParticipante').getStore().getCount();x++)
                                                                        {
                                                                            fila=gEx('gMailCParticipante').getStore().getAt(x);
                                                                            if(!validarCorreo(fila.data.mail))
                                                                            {
                                                                                function respMail()
                                                                                {
                                                                                    gEx('panelContactoCParticipante').setActiveTab(1);
                                                                                    gEx('gMailCParticipante').startEditing(x,1);
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
                                                                        
                                                                        
                                                                        var cadObjAux='{"calle":"'+cv(txtCalle.getValue())+'","noExt":"'+cv(txtNoExt.getValue())+
                                                                                    '","noInt":"'+cv(txtNoInt.getValue())+'","colonia":"'+cv(txtColonia.getValue())+
                                                                                    '","cp":"'+cv(txtCP.getValue())+'","estado":"'+cmbEstado.getValue()+
                                                                                    '","municipio":"'+cmbMunicipio.getValue()+'","localidad":"'+cv(txtLocalidad.getValue())+
                                                                                    '","entreCalle":"'+cv(txtEntreCalle.getValue())+'","yCalle":"'+cv(txtYCalle.getValue())+
                                                                                    '","referencias":"'+cv(txtReferencias.getValue())+'","arrTelefonos":['+arrTelefonos+
                                                                                    '],"mail":['+arrMail+'],"idRegistro":"-1","idFormulario":"-47"}';
                                                                        
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
                                                                                    objConf.afterRegister(arrResp[1],arrResp[2],tipoParticipante,arrResp[3],arrResp[4]);
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax, 'POST','funcion='+nFuncion+'&cadObj='+cadObj,true);
                                                                        
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
                                
	ventanaAM.objConf=objConf;     
    ventanaAM.listPartes=listPartes;  
    ventanaAM.tipoParticipante=tipoParticipante;                         
    
    
    if(!objConf || !objConf.idParticipante)
		ventanaAM.show();	
    else
    {
    	obtenerDatosIdentificacionVentana(objConf.idParticipante,tipoParticipante,ventanaAM,objConf);	
    }
}

function crearGridTelefonoCParticipante()
{
	var cmbTipoTelefonoCParticipante=crearComboExt('cmbTipoTelefonoCParticipante',arrTelefonosCParticipante);
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
                                                            editor:cmbTipoTelefonoCParticipante,
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrTelefonosCParticipante,val);
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
                                                            id:'gTelefonosCParticipante',
                                                            store:alDatos,
                                                            frame:false,
                                                            border:true,
                                                            x:10,
                                                            y:0,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,                                                            
                                                            columnLines : true,
                                                            height:145,
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
                                                            id:'gMailCParticipante',
                                                            store:alDatos,
                                                            frame:false,
                                                            border:true,
                                                            x:10,
                                                            y:150,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,                                                            
                                                            columnLines : true,
                                                            height:145,
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
                                                                                   
                                                                                    	gEx('gMailCParticipante').getStore().add(r);
                                                                                        gEx('gMailCParticipante').startEditing(gEx('gMailCParticipante').getStore().getCount()-1,1);
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover E-Mail',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=gEx('gMailCParticipante').getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar la direcci&oacute;n de e-mail a remover');
                                                                                        	return;
                                                                                        }
                                                                                        
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	gEx('gMailCParticipante').getStore().remove(fila);
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

function tipoPersonaCheckCP(rdo,value)
{
	var objConf=gEx('vParticipante').objConf;
	if(value)
    {
		switch(rdo.id)
        {
        	case 'tipoPersona_1':
            
            	gEx('lblNacionalidadIndique').hide();
                gEx('cmbNacionalidad').hide();
                gEx('cmbNacionalidad').setValue('');
                gEx('lblNacionalidadEspecifique').hide();
                gEx('txtOtraNacionalidad').hide();
                gEx('txtOtraNacionalidad').setValue('');
            	
            	gEx('lblNombre').setText('Nombre: <span style="color:#F00">*</span>',false);
                gEx('txtRazonSocial').setValue('');
                gEx('txtRazonSocial').hide();
                
            	gEx('lblNacionalidad').show();
                gEx('nacionalidad_0').show();
                gEx('nacionalidad_1').show();
                gEx('nacionalidad_2').show();
                gEx('nacionalidad_3').show();
                gEx('txtNombre').show();
                gEx('txtApPaterno').show();
                gEx('txtApMaterno').show();
                gEx('lblApPaterno').show();
                gEx('lblApMaterno').show();
                gEx('lblGenero').show();
                gEx('cmbGenero').show();
                
                gEx('txtRFC').setPosition(95,150);
				
                if(!objConf || !objConf.ocultaCedula)
                {
                    gEx('lblCedula').show();
                    gEx('txtCedula').show();
                }
                
                if(!objConf || !objConf.ocultaCURP)
                {
                    gEx('lblCURP').show();
                    gEx('txtCURP').show();
				}                
                if(!objConf || !objConf.ocultaFechaNacimiento)
                {
                    gEx('lblFechaNac').show();
                    gEx('fechaNacimiento').show();
                }
                if(!objConf || !objConf.ocultaEdad)
                {
                    gEx('lblEdad').show();
                    gEx('txtEdad').show();
                }
                if(!objConf || !objConf.ocultaEdad)
                {
                    gEx('lblEdoCivil').show();
                    gEx('cmbEstadoCivil').show();
                }
                if(!objConf || !objConf.ocultaIdentificacion)
                {
                    gEx('lblIdentificacion').show();
                    gEx('cmbIdentificacion').show();
                    gEx('txtEspecifique').show();
				}                
            break;
            case 'tipoPersona_2':
            	gEx('lblNacionalidadIndique').hide();
                gEx('cmbNacionalidad').hide();
                gEx('cmbNacionalidad').setValue('');
                gEx('lblNacionalidadEspecifique').hide();
                gEx('txtOtraNacionalidad').hide();
                gEx('txtOtraNacionalidad').setValue('');
                
	            gEx('txtRazonSocial').show();
                gEx('txtRazonSocial').focus();
            	gEx('lblNombre').setText('Raz&oacute;n social: <span style="color:#F00">*</span>',false);
            	gEx('lblNacionalidad').hide();
                gEx('nacionalidad_0').hide();
                gEx('nacionalidad_1').hide();
                gEx('nacionalidad_2').hide();
                gEx('nacionalidad_3').hide();
                
                gEx('txtNombre').hide();
                gEx('txtApPaterno').hide();
                gEx('txtApMaterno').hide();
                
                gEx('txtNombre').setValue('');
                gEx('txtApPaterno').setValue('');
                gEx('txtApMaterno').setValue('');
                gEx('cmbGenero').setValue('');
                
                gEx('lblApPaterno').hide();
                gEx('lblApMaterno').hide();
                gEx('lblGenero').hide();
                gEx('cmbGenero').hide();
                gEx('txtRFC').setPosition(115,150);
                gEx('lblCedula').hide();
                gEx('txtCedula').hide();
                gEx('txtCedula').setValue('');
                gEx('lblCURP').hide();
                gEx('txtCURP').hide();
                gEx('txtCURP').setValue('');
                
                gEx('lblFechaNac').hide();
                gEx('fechaNacimiento').hide();
                gEx('fechaNacimiento').setValue('');
                gEx('lblEdad').hide();
                gEx('txtEdad').hide();
                gEx('txtEdad').setValue('');
                gEx('lblEdoCivil').hide();
                gEx('cmbEstadoCivil').hide();
                gEx('cmbEstadoCivil').setValue('');
                gEx('lblIdentificacion').hide();
                gEx('cmbIdentificacion').hide();
                gEx('cmbIdentificacion').setValue('');
                gEx('txtEspecifique').hide();
                gEx('txtEspecifique').setValue('');
                
            break;
            
        }
    }
}

function tipoNacionalidadCheckCP(rdo,value)
{
	if(value)
    {
    	switch(rdo.id)
        {
        	case 'nacionalidad_0':
            case 'nacionalidad_2':
            	gEx('lblNacionalidadIndique').show();
                gEx('cmbNacionalidad').show();
            break;
            case 'nacionalidad_1':
            case 'nacionalidad_3':
            	gEx('lblNacionalidadIndique').hide();
                gEx('cmbNacionalidad').hide();
                gEx('lblNacionalidadEspecifique').hide();
                gEx('txtOtraNacionalidad').hide();
                gEx('txtOtraNacionalidad').setValue('');
                gEx('cmbNacionalidad').setValue('');
            break;
            
           
        }
    }
}

function crearArbolSujetosProcesalesRelacion(listPartes,iA,iP)
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
                                                                    iP:idPersona,
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
	var arbolSujetosJuridicos=new Ext.tree.TreePanel	(
                                                            {
                                                                id:'arbolSujetosRelacion',
                                                                useArrows:true,
                                                                animate:true,
                                                                enableDD:false,
                                                                ddScroll:true,
                                                                title:'Relacionado con:',
                                                                containerScroll: true,
                                                                autoScroll:true,
                                                                border:true,
                                                                x:670,
                                                                y:0,
                                                                disabled:listPartes=='-1',
                                                                height:350,
                                                                width:230,
                                                                root:raiz,
                                                                loader: cargadorArbol,
                                                                rootVisible:false
                                                            }
                                                        )
         
         
                                                    
	return  arbolSujetosJuridicos;
}

function buscarCedulaProfesional(noCedula)
{
	if(noCedula!='')
    {
        function funcAjax(peticion_http)
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
                if(arrResp[1]=='1')
                {
                    buscarParticipante(noCedula,1,'la c&eacute;dula profesional');
                }
                else
                {
                    function resp()
                    {
                        gEx('txtCedula').focus();
                    }                
                    msgBox('El n&uacute;mero de c&eacute;dula profesional no existe',resp);
                    return;
                }
                
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=32&noCedula='+noCedula,true);
	}
}

function buscarPorCURP(curp)
{
	if(curp!='')
    {
		buscarParticipante(curp,2,'la CURP');
	}
}

function buscarPorRFC(rfc)
{
	if(rfc!='')
    {
		buscarParticipante(rfc,3,'el RFC');
	}
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
        	
        	var oDatos=eval(arrResp[1])[0];
            
           
			if(oDatos.tipoPersona=='')
            	oDatos.tipoPersona='1';
            //gE('lblNombreTipo').innerHTML=formatearValorRenderer(arrParteProcesal,personaJuridica);
            
            var pos=existeValorMatriz(arrParteProcesal,personaJuridica);
            var cmbDetalle_P=gEx('cmbDetalle');
            cmbDetalle_P.getStore().loadData(arrParteProcesal[pos][2]);
            cmbDetalle_P.setValue(oDatos.detalleTipo);
            if(cmbDetalle_P.getStore().getCount()==0)
                cmbDetalle_P.hide();
            else
            	cmbDetalle_P.show();
            
            
            gEx('tipoPersona_'+oDatos.tipoPersona).setValue(true);
            tipoPersonaCheckCP(gEx('tipoPersona_'+oDatos.tipoPersona),true);
            gEx('nacionalidad_'+oDatos.esMexicano).setValue(true);
            tipoNacionalidadCheckCP(gEx('nacionalidad_'+oDatos.esMexicano),true);
            gEx('cmbNacionalidad').setValue(oDatos.nacionalidad);
            dispararEventoSelectCombo('cmbNacionalidad');
            gEx('txtOtraNacionalidad').setValue(oDatos.otraNacionalidad);
            
            gEx('txtRFC').setValue(oDatos.rfcEmpresa);
            gEx('txtCURP').setValue(oDatos.curp);
            gEx('txtCedula').setValue(oDatos.cedulaProfesional);
            
            gEx('txtNombre').setValue(oDatos.nombre);
            gEx('txtRazonSocial').setValue(oDatos.nombre);
            gEx('txtApPaterno').setValue(oDatos.apellidoPaterno);
            gEx('txtApMaterno').setValue(oDatos.apellidoMaterno);
            
            
            gEx('cmbGenero').setValue(oDatos.genero);
            gEx('fechaNacimiento').setValue(oDatos.fechaNacimiento);
            gEx('txtEdad').setValue(oDatos.edad);
            gEx('cmbEstadoCivil').setValue(oDatos.estadoCivil);
            gEx('cmbIdentificacion').setValue(oDatos.tipoIdentificacion);
            dispararEventoSelectCombo('cmbIdentificacion');
            gEx('txtEspecifique').setValue(oDatos.otraIdentificacion);
          
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
            	gEx('gAlias').getStore().add(r);
            }
            
            gEx('gAlias').enable();
            
            
            var txtCalle=gEx('txtCalleCParticipante');
            txtCalle.setValue(oDatos.datosContacto.calle);
            var txtNoExt=gEx('txtNoExtCParticipante');
            txtNoExt.setValue(oDatos.datosContacto.noExt);
            var txtNoInt=gEx('txtNoIntCParticipante');
            txtNoInt.setValue(oDatos.datosContacto.noInt);
            var txtColonia=gEx('txtColoniaCParticipante');
            txtColonia.setValue(oDatos.datosContacto.colonia);
            var txtCP=gEx('txtCPCParticipante');
            txtCP.setValue(oDatos.datosContacto.cp);
            var txtLocalidad=gEx('txtLocalidadCParticipante');
            txtLocalidad.setValue(oDatos.datosContacto.localidad);
            var txtEntreCalle=gEx('txtEntreCalleCParticipante');
            txtEntreCalle.setValue(oDatos.datosContacto.entreCalle);
            var txtYCalle=gEx('txtYCalleCParticipante');
            txtYCalle.setValue(oDatos.datosContacto.yCalle);
            var txtReferencias=gEx('txtReferenciasCParticipante');
            txtReferencias.setValue(oDatos.datosContacto.referencias);
            var cmbEstado=gEx('cmbEstadoCParticipante');
            cmbEstado.setValue(oDatos.datosContacto.estado);
            var cmbMunicipio=gEx('cmbMunicipioCParticipante');
            
            var posFila=obtenerPosFila(cmbEstado.getStore(),'id',oDatos.datosContacto.estado);
            if(posFila!=-1)
            {
                var registro=cmbEstado.getStore().getAt(posFila);
                obtenerMunicipiosCParticipante(cmbEstado,registro,function()
                                                                    {
                                                                        cmbMunicipio.setValue(oDatos.datosContacto.municipio);
                                                                    }
                                            )
			}            
            
            var regTel=crearRegistro	(
            								[
                                            	{name: 'tipoTelefono'},
                                                {name: 'lada'},
                                                {name: 'numero'},
                                                {name: 'extension'}
                                            
                                            ]
            							)
            
            var regMail=crearRegistro	(
            								[
                                            	{name: 'mail'}
                                            ]
            							);
            
            for(x=0;x<oDatos.datosContacto.telefonos.length;x++)
            {
            	var r=new regTel(oDatos.datosContacto.telefonos[x]);
                gEx('gTelefonosCParticipante').getStore().add(r);
            }
            
            for(x=0;x<oDatos.datosContacto.correos.length;x++)
            {
            	var r=new regMail(oDatos.datosContacto.correos[x]);
                gEx('gMailCParticipante').getStore().add(r);
            }
            
            
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
