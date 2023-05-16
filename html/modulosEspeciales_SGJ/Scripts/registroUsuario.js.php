<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$consulta="SELECT cveEstado,estado FROM 820_estados ORDER BY estado";
	$arrEstados=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT idTipoTelefono,tipoTelefono FROM 1006_tipoTelefono";
	$arrTelefonos=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__32_tablaDinamica,tipoIdentificacion,funcionValidacion,funcionAfterSelect,
				maxLongitud,caracteresPermitidos,indicaNacionalidadLocal,contieneFechaExpedicion,muestraTarjetaProfesional 
				FROM _32_tablaDinamica WHERE id__32_tablaDinamica NOT IN(13,14) ORDER BY tipoIdentificacion";
	$arrTiposIdentificacion=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__32_tablaDinamica,tipoIdentificacion,funcionValidacion,funcionAfterSelect,
				maxLongitud,caracteresPermitidos,indicaNacionalidadLocal,contieneFechaExpedicion,muestraTarjetaProfesional FROM _32_tablaDinamica 
				ORDER BY prioridad";
	$arrTipoIdentificacionConfiguracion=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idPais,nombre FROM 238_paises ORDER BY nombre";
	$arrPaises=$con->obtenerFilasArreglo($consulta);
?>
var errorRegistraduria=false;
var leyenda;
var control;
var arrPaises=<?php echo $arrPaises?>;
var uploadControl;                                                                                                            
var arrTelefonos=<?php echo $arrTelefonos?>;
var arrEstados=<?php echo $arrEstados?>;
var arrTipoIdentificacionConfiguracion=<?php echo $arrTipoIdentificacionConfiguracion?>;
var arrTiposIdentificacion=<?php echo $arrTiposIdentificacion?>;
Ext.onReady(inicializar);

function inicializar()
{
		inicializarGrid();

		new Ext.form.TextField	(
        							{
                                        width:280,
                                        id:'txtNombre',
                                        cls:'campoFormularioAzul',
                                        renderTo:'spPrimerNombre'
                                    }
        						)
	 													
		new Ext.form.TextField	(
        							{
                                        width:280,
                                        id:'txtApPaterno',
                                        cls:'campoFormularioAzul',
                                        renderTo:'spPrimerApellido'
                                    }
        						)
                                
                                
		new Ext.form.TextField	(
        							{
                                        width:300,
                                        id:'txtApMaterno',
                                        cls:'campoFormularioAzul',
                                        renderTo:'spSegundoApellido'
                                    }
        						) 

		new Ext.form.TextField	(
        							{
                                        width:280,
                                        cls:'campoFormularioAzul',
                                        id:'noIdentificacion',
                                        enableKeyEvents :true,

                                        listeners:	{
                                                        keypress:function(txt,e)
                                                            {
  																var cmbIdentificacion=gEx('cmbTipoIdentificacion');
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
                                                                            realizarBusquedaPersona();
                                                                        }
                                                                    }
                                                                }
                                                                
                                                                var posDocumento=existeValorMatriz(arrTipoIdentificacionConfiguracion,cmbIdentificacion.getValue());
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
                                                            	var cmbIdentificacion=gEx('cmbTipoIdentificacion');
                                                                if(txt.getValue()=='')
                                                                    return;
                                                                if(validarNoIdentificacion(1))
                                                                {  
                                                                    if(txt.ultimaBusqueda!=txt.getValue())
                                                                    {
                                                                        txt.ultimaBusqueda=txt.getValue();
                                                                        realizarBusquedaPersona();
                                                                       
                                                                    }
                                                                }
                                                                
                                                            }
                                                    },
                                        			
                                        renderTo:'spNumeroIdentificacion'
                                    }
        						) 
                                
        
        
        new Ext.form.TextField	(
        							{
                                        width:280,
                                        cls:'campoFormularioAzul',
                                        id:'email',
                                        renderTo:'spEmail'
                                    }
        						) 
                                
		new Ext.form.TextField	(
        							{
                                        width:280,
                                        cls:'campoFormularioAzul',
                                        id:'email2',
                                        renderTo:'spEmail2'
                                    }
        						)                                 


		new Ext.form.TextField	(
        							{
                                        width:280,
                                        cls:'campoFormularioAzul',
                                        id:'txtCalle',
                                        renderTo:'spDireccion'
                                    }
        						) 
                                
		new Ext.form.TextField	(
        							{
                                        width:280,
                                        cls:'campoFormularioAzul',
                                        id:'txtColonia',
                                        renderTo:'spBarrio'
                                    }
        						) 
                                
                                
		new Ext.form.TextField	(
        							{
                                        width:280,
                                        cls:'campoFormularioAzul',
                                        id:'txtCP',
                                        renderTo:'spCP'
                                    }
        						)                                                                 
                                
		new Ext.form.DateField	(
        							{
                                        xtype:'datefield',
                                        id:'dteFechaExp',
                                        width:270,
                                        listeners:	{
                                        				'select':function()
                                                        		{
                                                                	realizarBusquedaPersona();
                                                                }
                                        			},
                                        ctCls:'campoFechaSIUGJAzul',
                                        renderTo:'spFechaExpedicion'
                                    }
        						)                                                                


		new Ext.form.DateField	(
        							{
                                        xtype:'datefield',
                                        id:'dteFechaNac',
                                        width:270,
                                        ctCls:'campoFechaSIUGJAzul',
                                        renderTo:'spFechaNacimiento'
                                    }
        						)            

                                
    	var cmbEstado=crearComboExt('cmbEstado',arrEstados,0,0,275,{renderTo:'spDepartamento',ctCls:'comboWrapSIUGJAzul',listClass :'listComboSIUGJAzul'});
        cmbEstado.on('select',function(cmb,registro)
                            {
                                var valor=registro.data.id;
        
                                function funcAjax()
                                {
                                    var resp=peticion_http.responseText;
                                    arrResp=resp.split('|');
                                    if(arrResp[0]=='1')
                                    {
                                        gEx('cmbMunicipio').setValue('');
                                        var arrMunicipios=eval(arrResp[1]);
                                        gEx('cmbMunicipio').getStore().loadData(arrMunicipios);
                                    }
                                    else
                                    {
                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                    }
                                }
                                obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcAjax, 'POST','funcion=29&cveEstado='+valor,true);
                            }
                    )
        var cmbMunicipio=crearComboExt('cmbMunicipio',[],0,0,275,{renderTo:'spMunicipio',ctCls:'comboWrapSIUGJAzul',listClass :'listComboSIUGJAzul'});
        var cmbTipoIdentificacion=crearComboExt('cmbTipoIdentificacion',arrTiposIdentificacion,0,0,275,{renderTo:'spTipoIdentificacion',ctCls:'comboWrapSIUGJAzul',listClass :'listComboSIUGJAzul'});
        
        cmbTipoIdentificacion.on('select',function(cmb,registro)
        									{
        
        										var pos=existeValorMatriz(arrTipoIdentificacionConfiguracion,registro.data.id);
                                                                                                        
                                                var fila=arrTipoIdentificacionConfiguracion[pos];
                                                
                                                
                                                if(fila[7]=='1')
                                                {
                                                    mE('lblFechaExpedicion');
                                                    mE('divFechaDocumento');	
                                                }
                                                else
                                                {
                                                    oE('lblFechaExpedicion');
                                                    oE('divFechaDocumento');	
                                                }
                                                
                                                
                                            	gEx('dteFechaExp').setValue('');
                                                gEx('noIdentificacion').setValue('');
                                                
                                                if(fila[3]!='')
                                                {
                                                    eval(fila[3]+'('+registro.data.id+',registro);');
                                                }
											}
        )
        
        new Ext.form.Radio(
        						 {
                                 	  x:0,
                                      y:0,
                                      id:'rdoHombre',
                                      name:'radioGenero',
                                      xtype:'radio',
                                      ctCls:'campoRadioAzul',
                                      renderTo:'spGenero1',
                                      boxLabel:'Hombre'
                                  }
                         )
                         
                         
         
          new Ext.form.Radio(
        						{
                                	x:120,
                                    y:0,
                                    name:'radioGenero',
                                    ctCls:'campoRadioAzul',
                                    xtype:'radio',
                                    id:'rdoMujer',
                                    boxLabel:'Mujer',
                                    renderTo:'spGenero2'
                                 }
                         ) 
         
                         
		 new Ext.form.Radio(
        						 {
                                 	  x:250,
                                      y:0,
                                      name:'radioGenero',
                                      ctCls:'campoRadioAzul',
                                      xtype:'radio',
                                      id:'rdoOtro',
                                      boxLabel:'Otro',
                                      renderTo:'spGenero3'
                                  }
                         );
		
         
         
		new Ext.form.Checkbox	(
        							{
                                    	
                                        listeners:	{
                                                        check:function(chk,valor)
                                                                {
                                                                    if(valor)
                                                                    {
                                                                        gEx('btnAceptar').enable();
                                                                    }
                                                                    else
                                                                    {
                                                                        gEx('btnAceptar').disable();
                                                                    }
                                                                }
                                                    },
                                        id:'chkAceptacion',
                                        renderTo:'spPoliticas',
                                        cls:'letraPoliticasPrivacidad',
                                        boxLabel:'<span class="letraPoliticasPrivacidad">Conozco y acepto las políticas de privacidad, términos y condiciones de uso y el tratamiento '+
                                                    'que la entidad har&aacute; a mis datos personales.</span>'
                                    }
        						)            
         
      new Ext.form.Label	(
									{
                                        renderTo:'spPoliticasVer',
                                        html:'<span class="letraPoliticasPrivacidad">Para conocer los términos y condiciones dé  <a href="javascript:verTerminos()"><span style="color:#900; font-weight:bold">Click aqu&iacute;</span></a></span>'
                                    }
                                )                                        
         
		crearGridTelefonoContacto();          
		                                                 
                                  
        gEx('txtNombre').focus();
		new Ext.Button	(
                            {
                             	  
                                cls:'btnSIUGJ',
                                renderTo:'btnFinalizar',
                                text:'FINALIZAR REGISTRO',
                                width:280,
                                height:30,
                                disabled:true,                                
                                id:'btnAceptar',
                                handler:function()
                                        {
                                            var mail=gEx('email').getValue();
                                            var mail2=gEx('email2').getValue();
                                            
                                            
                                            
                                            var cmbTipoIdentificacion=gEx('cmbTipoIdentificacion');
                                            var noIdentificacion=gEx('noIdentificacion');
                                            
                                           
                                      
                                      
                                            if(validar())
                                            {
                                            	if(cmbTipoIdentificacion.getValue()=='')
                                                {
                                                    function respAux100()
                                                    {
                                                        cmbTipoIdentificacion.focus();
                                                    }
                                                    msgBox('Debe seleccionar el tipo de identificaci&oacute;n a presentar',respAux100);
                                                    return false;
                                                }
                                                
                                                
                                                if((isVisible('txtEspecifique'))&&(noIdentificacion.getValue()==''))
                                                {
                                                    function respAux101()
                                                    {
                                                        noIdentificacion.focus();
                                                    }
                                                    msgBox('Debe ingresar el n&uacute;mero de identificacion a presentar',respAux101);
                                                    return false;
                                                }
                                                
                                               
                                                
                                                
                                                if((isVisible('divFechaDocumento')) && (gEx('dteFechaExp').getValue()==''))
                                                {
                                                    function respAux()
                                                    {
                                                        gEx('dteFechaExp').focus();
                                                    }
                                                    msgBox('Debe ingresar la fecha de expedici&oacute;n del documento de identificacion',respAux);
                                                    return;
                                                    
                                                }
                                                
    
        
                                                
                                                if(!validarCorreo(mail))
                                                {
                                                    function funcAceptar2()
                                                    {
                                                        gE('email').focus();
                                                        
                                                    }
                                                    msgBox('La direcci&oacute;n de correo electr&oacute;nico ingresada no es v&aacute;lida',funcAceptar2);
                                                    return false;
                                                }
                                            
                                                if(mail!=mail2)
                                                {
                                                    function respMail()
                                                    {
                                                        gEx('email').focus();
                                                    }
                                                    msgBox('Las direcciones de correo electr&oacute;nico ingresadas NO coinciden',respMail);
                                                    return false;
                                                }
                                                
                                                if(errorRegistraduria)
                                                {
                                                    function resp100()
                                                    {
                                                        control.focus();
                                                    }
                                                    msgBox(leyenda,resp100)
                                                    return;
                                                }
                                                function funcAjax()
                                                {
                                                    var resp=peticion_http.responseText;
                                                    arrResp=resp.split('|');
                                                    if(arrResp[0]=='1')
                                                    {
                                                    	if(isVisible('campoDocumentoIdentificacion'))
                                                        {
                                                            if(uploadControl.files.length==0)
                                                            {
                                                                msgBox('Debe ingresar el documento de identificaci&oacute;n');
                                                                return;
                                                            }
                                                            gEx('btnAceptar').disable();
                                                            uploadControl.start();   
                                                        }
                                                        else
                                                        {
                                                        	registrarCuentaUsuario()
                                                        
                                                        }
                                                    }
                                                    else
                                                    {
                                                    	if(arrResp[0]=='3')
                                                        {
                                                            msgBox('El n&uacute;mero de identificaci&oacute;n ingresado ya ha sido registrada previamente');
                                                        }
                                                        else
                                                            if(arrResp[0]=='2')
                                                            {
                                                                msgBox('La direcci&oacute;n de correo electr&oacute;nico ingresada ya ha sido registrada previamente');
                                                            }
                                                            else
                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                    }
                                                }
                                                obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax,
                                                				'POST','funcion=192&tIdentificacion='+cmbTipoIdentificacion.getValue()+
                                                                '&noIdentificacion='+cv(noIdentificacion.getValue())+'&mail='+cv(mail),true);
                                            
                                                
                                            }
                                        }
                                
                            }
                        )
      
    	
 
	
}

function realizarBusquedaPersona()
{
	errorRegistraduria=false;
    
	

	if((gEx('cmbTipoIdentificacion').getValue()=='')||(gEx('noIdentificacion').getValue()=='')||(gEx('dteFechaExp').getValue()==''))
    {
    	return;
    }

	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var resp1=bD(arrResp[2]);

            var objDatos=eval('['+resp1+']')[0];
            if((objDatos.esInfoWS=='1')&&(objDatos.conInformacion=='1'))
            {
            	if(gEx('txtNombre').getValue()!=objDatos.datosParticipante.nombre)
                {
                	errorRegistraduria=true;
                    leyenda='El primer nombre no coincide con registradur&iacute;a';
                	function resp1()
                    {
                    	control=gEx('txtNombre');
                    	control.focus();
                    }
                    msgBox(leyenda,resp1)
                	return;
                }
                
                
                if(gEx('txtApPaterno').getValue()!=objDatos.datosParticipante.apellidoPaterno)
                {
                	errorRegistraduria=true;
                    leyenda='El primer apellido no coincide con registradur&iacute;a';
                	function resp2()
                    {
                    	control=gEx('txtApPaterno');
                    	control.focus();
                    }
                    msgBox(leyenda,resp2)
                	return;
                }
                
                
                if(gEx('txtApMaterno').getValue()!=objDatos.datosParticipante.apellidoMaterno)
                {
	                errorRegistraduria=true;
                    leyenda='El segundo apellido no coincide con registradur&iacute;a';
                	function resp3()
                    {
                    	control=gEx('txtApMaterno');
                    	control.focus();
                    }
                    msgBox(leyenda,resp3)
                	return;
                }
                
                
                if(gEx('dteFechaExp').getValue().format('Y-m-d')!=objDatos.datosParticipante.fechaIdentificacion)
                {
                	errorRegistraduria=true;
                    leyenda='La fecha de expedición del documento no coincide con registradur&iacute;a';
                	function resp4()
                    {
                    	control=gEx('dteFechaExp');
                    	control.focus();
                    }
                    msgBox(leyenda,resp4)
                	return;
                }
                
            }
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesModuloRegistroPartes.php',funcAjax, 'POST','funcion=2&tB='+gEx('cmbTipoIdentificacion').getValue()+'&vB='+gEx('noIdentificacion').getValue()+'&iF=0&tipoEntidad=0',true);
}

function crearGridTelefonoContacto()
{
	var cmbPais=crearComboExt('cmbPais',arrPaises,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
	var cmbTipoTelefono=crearComboExt('cmbTipoTelefono',arrTelefonos,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'tipoTelefono'},
                                                                    {name: 'lada'},
                                                                    {name: 'pais'},
                                                                    {name: 'numero'},
                                                                    {name: 'extension'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true,width:40});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	
														chkRow,
														{
															header:'Tipo',
															width:130,
                                                            menuDisabled :true,
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
                                                            menuDisabled :true,
                                                            hidden:true,
															sortable:true,
															dataIndex:'lada',
                                                            editor:	{
                                                            			xtype:'textfield',
                                                                        cls:'SIUGJ_Control'
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
															width:160,
                                                            menuDisabled :true,
															sortable:true,
															dataIndex:'numero',
                                                            editor:	{
                                                            			xtype:'numberfield',
                                                                        allowDecimals:false,
                                                                        cls:'SIUGJ_Control',
                                                                        allowNegative:false
                                                            		}
														},
                                                        {
															header:'Extensi&oacute;n',
															width:120,
                                                            menuDisabled :true,
															sortable:true,
															dataIndex:'extension',
                                                            editor:	{
                                                            			xtype:'numberfield',
                                                                        allowDecimals:false,
                                                                        allowNegative:false,
                                                                        cls:'SIUGJ_Control'
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
                                                            cls:'gridSiugjCampoAzul',
                                                           	renderTo:'gTelefonosContacto',
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            clicksToEdit:1,
                                                            loadMask:true,
                                                            stripeRows :true,                                                            
                                                            columnLines : true,
                                                            height:200,
                                                            width:700,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../principalPortal/imagesSIUGJ/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            height:50,
                                                                            width:230,
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
                                                                                   
                                                                                    	gEx('gTelefonos').getStore().add(r);
                                                                                        gEx('gTelefonos').startEditing(gEx('gTelefonos').getStore().getCount()-1,1);
                                                                                    }
                                                                            
                                                                        },
                                                                        {
                                                                        	icon:'../principalPortal/imagesSIUGJ/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            height:50,
                                                                            width:230,
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
	
}

function registrarCuentaUsuario()
{
    var apPaterno=gEx('txtApPaterno').getValue();
    var apMaterno=gEx('txtApMaterno').getValue();
    var nombre=gEx('txtNombre').getValue();
    var mail=gEx('email').getValue();
    
    
    codInstitucion='10000004';
    
    var prefijo='';
    var sexo=0;
    if(gEx('rdoHombre').getValue())
        sexo=0;
    else
        if(gEx('rdoMujer').getValue())
            sexo=1;
		else
        	sexo=2;
    
    var telefonos='';
    
    var x;
    var t;
    var fila;
    var gTelefonos=gEx('gTelefonos');
    for(x=0;x<gTelefonos.getStore().getCount();x++)
    {
        fila=gTelefonos.getStore().getAt(x);
        t=fila.data.tipoTelefono+'__'+fila.data.pais+'__'+fila.data.lada+'__'+fila.data.numero+'__'+fila.data.extension;
        if(telefonos=='')
            telefonos=t;
        else
            telefonos+=','+t;
    }
    
    
    var cmbTipoIdentificacion=gEx('cmbTipoIdentificacion');
    var noIdentificacion=gEx('noIdentificacion');
    
    
    var datosAutor='{"idProceso":"100","sexo":"'+sexo+'","fechaNacimiento":"'+gEx('dteFechaNac').getValue().format('Y-m-d')+
                    '","prefijo":"'+cv(prefijo)+'","idProceso":"0","identificacion":"'+gEx("idArchivo").getValue()+
                    '","fechaExpDocumento":"'+(gEx('dteFechaExp').getValue()!=''?gEx('dteFechaExp').getValue().format('Y-m-d'):'')+'","nombreDocumento":"'+cv(gEx("nombreArchivo").getValue())+'","apPaterno":"'+cv(apPaterno)+
                '","apMaterno":"'+cv(apMaterno)+'","nombres":"'+cv(nombre)+'","email":"'+cv(mail)+'","codInstitucion":"'+cv(codInstitucion)+
                '","codDepto":"'+cv(codInstitucion)+'","tipoIdentificacion":"'+cmbTipoIdentificacion.getValue()+
                '","noIdentificacion":"'+cv(noIdentificacion.getValue())+'","telefonos":"'+telefonos+
                '","direccion":{"calle":"'+gEx('txtCalle').getValue()+'","noInt":"","noExt":"","colonia":"'+
                gEx('txtColonia').getValue()+'","cp":"'+gEx('txtCP').getValue()+'","estado":"'+gEx('cmbEstado').getValue()+'","municipio":"'+
                gEx('cmbMunicipio').getValue()+'"}}';
    
    function funcGuardar()
    {
        var arrResp=peticion_http.responseText.split("|");
        if(arrResp[0]=='1')
        {
            function respMail()
            {
                if(window.parent.cerrarVentanaFancy!=undefined)
                    window.parent.cerrarVentanaFancy();
            }
            msgBox('Su cuenta ha sido registrada de manera exitosa, en breve recibir&aacute; un correo electr&oacute;nico con sus datos de acceso',respMail);   
            return;
        }
        else
            msgBox('<?php echo $etj["errOperacion"].' '?>'+arrResp[0]);
    }
    obtenerDatosWeb("../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php",funcGuardar,'POST','funcion=6&'+'datosAutor='+datosAutor,true);//33
    
}


function validar()
{
	var nombre=gEx('txtNombre').getValue();
	if(trim(nombre)=='')
	{
		function funcAceptar()
		{
			gEx('txtNombre').focus();
			
		}
		msgBox('El campo Nombre  es obligatorio',funcAceptar);
		return false;
	}
    
    var txtApPaterno=gEx('txtApPaterno').getValue();
	if(trim(txtApPaterno)=='')
	{
		function funcAceptar2()
		{
			gEx('txtApPaterno').focus();
			
		}
		msgBox('El campo Primer Apellido  es obligatorio',funcAceptar2);
		return false;
	}
	
    var dteFechaNac=gEx('dteFechaNac');
    if(dteFechaNac.getValue()=='')
    {
    	function resp3()
        {
        	dteFechaNac.focus();
        }
    	msgBox('El campo Fec. Nacimiento es obligatorio',resp3);
    	return false;
    }
	
    var rdoHombre=gEx('rdoHombre');
    var rdoMujer=gEx('rdoMujer');
    var rdoOtro=gEx('rdoOtro');
    
    if((rdoHombre.getValue()=='')&&(rdoMujer.getValue()=='')&&(rdoOtro.getValue()==''))
    {
    	function resp4()
        {
        	rdoHombre.focus();
        }
    	msgBox('El campo G&eacute;nero es obligatorio',resp3);
    	return false;
    }
    
    
    
    
    var cmbEstado=gEx('cmbEstado');
    if(cmbEstado.getValue()=='')
    {
    	function resp5()
        {
        	cmbEstado.focus();
        }
    	msgBox('El campo Departamento es obligatorio',resp5);
    	return false;
    }
    
    var cmbMunicipio=gEx('cmbMunicipio');
    if(cmbMunicipio.getValue()=='')
    {
    	function resp6()
        {
        	cmbMunicipio.focus();
        }
    	msgBox('El campo Municipio es obligatorio',resp6);
    	return false;
    }
    
	return true;
}

function subidaCorrecta(file, serverData) 
{
	gEx('btnAceptar').enable();
	
    file.id = "singlefile";	// This makes it so FileProgress only makes a single UI element, instead of one for each file
    var arrDatos=serverData.split('|');

    if ( arrDatos[0]!='1') 
    {
    	
    } 
    else 
    {
        
        gEx("idArchivo").setValue(arrDatos[1]);
        gEx("nombreArchivo").setValue(arrDatos[2]);
       	
        registrarCuentaUsuario();
        
    }
		
	
}


function verTerminos()
{
	var obj={};
    obj.ancho='90%';
    obj.alto='90%';
    obj.titulo='Términos y condiciones';
    obj.url='../modulosEspeciales_SGJ/terminosCondiciones.php';
    abrirVentanaFancy(obj);
}



function inicializarGrid()
{
	 var cObj={

                    upload_url: "../modulosEspeciales_SGJP/procesarComprobante.php", //lquevedor
                    file_post_name: "archivoEnvio",
     
                    // Flash file settings
                    file_size_limit :'100MB',
                    file_types : '*.pdf;*.png;*.jpeg;*.jpg;*.bpm;*.gif',
                    file_types_description : "Todos los archivos",
                    file_upload_limit : 0,
                    file_queue_limit : 1,
                    ancho:270,
     				leyendaSeleccione:'Seleccione Documento',                   
                    upload_success_handler : subidaCorrecta,
                    
                    
                }
   
    
	new Ext.Panel	(
    					{
                        	renderTo:'spDocumentoIdentificacion',
                            width:300,
                            height:30,
                            border:false,
                            layout:'absolute',
                            items:	[
                            			{
                                        	x:0,
                                            y:0,
                                            width:300,
                                            height:30,
                                            xtype:'panel',
                                            border:false,
                                            cls:'campoDocumentoAzul',
                                            defaultType: 'label',
                                            layout:'absolute',
                                            items:	[
                                            			
                                                        
                                                        
                                                         {
                                                            x:0,
                                                            y:0,
                                                            html:	'<table width="180"><tr><td><div id="uploader"><p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p></div></td></tr></table>'
                                                        },
                                                       
                                                        {
                                                            x:275,
                                                            y:1,
                                                            id:'btnUploadFile',
                                                            xtype:'button',
                                                            icon:'../principalPortal/imagesSIUGJ/clip.png',
                                                            cls:'x-btn-text-icon',
                                                            handler:function()
                                                                    {
                                                                        $('#containerUploader').click();
                                                                    }
                                                        },
                                                        
														 {
                                                            x:0,
                                                            y:0,
                                                            hidden:true,
                                                            html:	'<div id="containerUploader"></div>'
                                                        },
                                                        
                                                        {
                                                            x:0,
                                                            y:0,
                                                            xtype:'hidden',
                                                            id:'idArchivo'

                                                        },
                                                        {
                                                            x:290,
                                                            y:0,
                                                            xtype:'hidden',
                                                            id:'nombreArchivo'
                                                        } 
                                                       
                                                        
                                            		]                                            
                                        }
                            		]
                        }
    				)
	
    
     crearControlUploadHTML5(cObj);
}



function deshabilitarNumeroIdentificacion(tipoIdentificacion,registro)
{
	oE('txtEspecifique');
    oE('lblDocumentoIdentificacion');
    oE('campoDocumentoIdentificacion');
    gE('noIdentificacion').value='';
    oE('lblNoIdentificacion');
}

function habilitarNumeroIdentificacion(tipoIdentificacion,registro)
{
	mE('txtEspecifique');
    mE('lblNoIdentificacion');
    gE('noIdentificacion').value='';
    mE('lblDocumentoIdentificacion');
    mE('campoDocumentoIdentificacion');
    //gEx('txtEspecifique').ultimaBusqueda='';
    
    
    
    
    
    
}


function validarNoIdentificacion(tipoValidacion)
{
	var valor=gE('noIdentificacion').value;
 	var tipoIdentificacion=gEx('cmbTipoIdentificacion').getValue();
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
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n debe ser de 11 caracteres',resp);
        	return false;
        }
        
        
        if(!re.test(valor))
        {
        	function resp2()
            {
            	gE('noIdentificacion').focus();
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
            	gE('noIdentificacion').focus();
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
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n debe ser de 3 a 10 caracteres',resp);
        	return false;
        }
        
        
        if(!re.test(valor))
        {
        	function resp2()
            {
            	gE('noIdentificacion').focus();
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
            	gE('noIdentificacion').focus();
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
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n debe ser de 6 caracteres',resp);
        	return false;
        }
        
        
        if(!re.test(valor))
        {
        	function resp2()
            {
            	gE('noIdentificacion').focus();
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
            	gE('noIdentificacion').focus();
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
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n debe ser de 9 caracteres',resp);
        	return false;
        }
        
        
        if(!re.test(valor))
        {
        	function resp2()
            {
            	gE('noIdentificacion').focus();
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
            	gE('noIdentificacion').focus();
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
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n debe ser de 16 caracteres',resp);
        	return false;
        }
        
        
        if(!re.test(valor))
        {
        	function resp2()
            {
            	gE('noIdentificacion').focus();
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
            	gE('noIdentificacion').focus();
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
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n debe ser de 6 a 16 caracteres',resp);
        	return false;
        }
        
        
        if(!re.test(valor))
        {
        	function resp2()
            {
            	gE('noIdentificacion').focus();
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
            	gE('noIdentificacion').focus();
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
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n debe ser de 15 caracteres',resp);
        	return false;
        }
        
        
        if(!re.test(valor))
        {
        	function resp2()
            {
            	gE('noIdentificacion').focus();
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
            	gE('noIdentificacion').focus();
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
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n debe ser de 11 caracteres',resp);
        	return false;
        }
        
        
        if(!re.test(valor))
        {
        	function resp2()
            {
            	gE('noIdentificacion').focus();
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
            	gE('noIdentificacion').focus();
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
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n debe ser de 9 caracteres',resp);
        	return false;
        }
        
        
        if(!re.test(valor))
        {
        	function resp2()
            {
            	gE('noIdentificacion').focus();
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
            	gE('noIdentificacion').focus();
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
            	gE('noIdentificacion').focus();
            }
            msgBox('El n&uacute;mero de identificaci&oacute;n debe ser de 11 digitos',resp);
        	return false;
        }
        
        
        if(!re.test(valor))
        {
        	function resp2()
            {
            	gE('noIdentificacion').focus();
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
            	gE('noIdentificacion').focus();
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



