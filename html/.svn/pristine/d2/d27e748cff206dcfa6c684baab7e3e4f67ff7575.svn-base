<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$consulta="SELECT cveEstado,estado FROM 820_estados ORDER BY estado";
	$arrEstados=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT idTipoTelefono,tipoTelefono FROM 1006_tipoTelefono";
	$arrTelefonos=$con->obtenerFilasArreglo($consulta);
?>
var arrTelefonos=<?php echo $arrTelefonos?>;
var arrEstados=<?php echo $arrEstados?>;
Ext.onReady(inicializar);

function inicializar()
{
	
	var cmbEstado=crearComboExt('cmbEstado',arrEstados,90,65,250);
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
    var cmbMunicipio=crearComboExt('cmbMunicipio',[],460,65,250);
	new Ext.Panel	(
    					{
                        	renderTo:'spContenedor',
                            width:800,
                            height:600,
                            border:false,
                            layout:'absolute',
                            items:	[
                            			{
                                        	x:0,
                                            y:0,
                                            width:800,
                                            height:160,
                                            xtype:'fieldset',
                                            title:'Datos Generales',
                                            layout:'absolute',
                                            items:	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            xtype:'label',
                                                            html:'<b>Nombre: <span style="color:#F00">*</span></b>'
                                                        },
                                                        {
                                                        	x:90,
                                                            y:5,
                                                            xtype:'textfield',
                                                            width:140,
                                                            id:'txtNombre'
                                                        },
                                                        {
                                                        	x:260,
                                                            y:10,
                                                            xtype:'label',
                                                            html:'<b>Ap. Paterno: <span style="color:#F00">*</span></b>'
                                                        },
                                                        {
                                                        	x:360,
                                                            y:5,
                                                            xtype:'textfield',
                                                            width:120,
                                                            id:'txtApPaterno'
                                                        },
                                                        {
                                                        	x:510,
                                                            y:10,
                                                            xtype:'label',
                                                            html:'<b>Ap. Materno:</b>'
                                                        },
                                                        {
                                                        	x:610,
                                                            y:5,
                                                            xtype:'textfield',
                                                            width:120,
                                                            id:'txtApMaterno'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            xtype:'label',
                                                            html:'<b>Fec. Nacimiento: <span style="color:#F00">*</span></b>'
                                                        },
                                                        {
                                                        	x:145,
                                                            y:35,
                                                            xtype:'datefield',
                                                            id:'dteFechaNac'
                                                        },
                                                        {
                                                        	x:290,
                                                            y:40,
                                                            xtype:'label',
                                                            html:'<b>G&eacute;nero: <span style="color:#F00">*</span></b>'
                                                        },
                                                        {
                                                        	x:360,
                                                            y:35,
                                                            id:'rdoHombre',
                                                            name:'radioGenero',
                                                            xtype:'radio',
                                                            boxLabel:'Hombre'
                                                        },
                                                        {
                                                        	x:460,
                                                            y:35,
                                                            name:'radioGenero',
                                                            xtype:'radio',
                                                            id:'rdoMujer',
                                                            boxLabel:'Mujer'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            xtype:'label',
                                                            html:'<b>Ingrese su direcci&oacute;n de correo electr&oacute;nico: <span style="color:#F00">*</span></b>'
                                                        },
                                                         {
                                                        	x:360,
                                                            y:65,
                                                            xtype:'textfield',
                                                            width:370,
                                                            id:'email'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            xtype:'label',
                                                            html:'<b>Confirme su direcci&oacute;n de correo electr&oacute;nico: <span style="color:#F00">*</span></b>'
                                                        },
                                                         {
                                                        	x:360,
                                                            y:95,
                                                            xtype:'textfield',
                                                            width:370,
                                                            id:'email2'
                                                        }
                                                        
                                            		]                                            
                                        },
                                        {
                                        	x:0,
                                            y:160,
                                            width:800,
                                            height:280,
                                            xtype:'fieldset',
                                            title:'Datos de Contacto',
                                            layout:'absolute',
                                            items:	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            xtype:'label',
                                                            html:'<b>Calle:</b>'
                                                            
                                                        },
                                                        {
                                                        	x:90,
                                                            y:5,
                                                            xtype:'textfield',
                                                            width:250,
                                                            id:'txtCalle'
                                                            
                                                        },
                                                        {
                                                        	x:360,
                                                            y:10,
                                                            xtype:'label',
                                                            html:'<b>No. Int.:</b>'
                                                            
                                                        },
                                                        {
                                                        	x:440,
                                                            y:5,
                                                            xtype:'textfield',
                                                            width:100,
                                                            id:'txtNoInt'
                                                            
                                                        },
                                                        {
                                                        	x:560,
                                                            y:10,
                                                            xtype:'label',
                                                            html:'<b>No. Ext.:</b>'
                                                            
                                                        },
                                                        {
                                                        	x:640,
                                                            y:5,
                                                            xtype:'textfield',
                                                            width:100,
                                                            id:'txtNoExt'
                                                            
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            xtype:'label',
                                                            html:'<b>Colonia:</b>'
                                                            
                                                        },
                                                        {
                                                        	x:90,
                                                            y:35,
                                                            xtype:'textfield',
                                                            width:200,
                                                            id:'txtColonia'
                                                            
                                                        },
                                                        {
                                                        	x:360,
                                                            y:40,
                                                            xtype:'label',
                                                            html:'<b>C.P.:</b>'
                                                            
                                                        },
                                                        {
                                                        	x:440,
                                                            y:35,
                                                            xtype:'numberfield',
                                                            width:80,
                                                            id:'txtCP',
                                                            allowDecimals:false,
                                                            allowNegative:false
                                                            
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            xtype:'label',
                                                            html:'<b>Estado: <span style="color:#F00">*</span></b>'
                                                            
                                                        },
                                                        cmbEstado,
                                                        {
                                                        	x:360,
                                                            y:70,
                                                            xtype:'label',
                                                            html:'<b>Municipio: <span style="color:#F00">*</span></b>'
                                                            
                                                        },
                                                        cmbMunicipio,
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            xtype:'label',
                                                            html:'<b>Tel&eacute;fonos de contacto:</b>'
                                                            
                                                        },
                                                        crearGridTelefonoContacto()
                                            		]                                            
                                        },
                                        {
                                        	xtype:'button',
                                            x:500,
                                            y:460,
                                            height:40,
                                            width:140,
                                            icon:'../images/icon_tick.gif',
                                            cls:'x-btn-text-icon',
                                            text:'Finalizar Registro',
                                            handler:function()
                                                  {
                                                      registrarCuentaUsuario();
                                                  }
                                        }
                            		]
                        }
    				)
	gEx('txtNombre').focus();
}



function crearGridTelefonoContacto()
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
                                                            x:200,
                                                            y:95,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            clicksToEdit:1,
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

function registrarCuentaUsuario()
{
	var mail=gEx('email').getValue();
    var mail2=gEx('email2').getValue();
	if(!validarCorreo(mail))
	{
		function funcAceptar2()
		{
			gE('email').focus();
			
		}
		msgBox('La direcci&oacute;n de correo electr&oacute;nico ingresada no es v&aacute;lida',funcAceptar2);
		return;
	}

	if(mail!=mail2)
    {
    	function respMail()
        {
        	gEx('email').focus();
        }
    	msgBox('Las direcciones de correo electr&oacute;nico ingresadas NO coinciden',respMail);
    	return;
    }

	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	if(validar())
            {
                var apPaterno=gEx('txtApPaterno').getValue();
                var apMaterno=gEx('txtApMaterno').getValue();
                var nombre=gEx('txtNombre').getValue();
                var mail=gEx('email').getValue();
                
                
                codInstitucion='0000';
                
                var prefijo='';
                var sexo=0;
                if(gEx('rdoMujer').getValue())
                	sexo=1;
                var telefonos='';
                
                var x;
                var t;
                var fila;
                var gTelefonos=gEx('gTelefonos');
                for(x=0;x<gTelefonos.getStore().getCount();x++)
                {
                	fila=gTelefonos.getStore().getAt(x);
                    t=fila.data.tipoTelefono+'__'+fila.data.lada+'_'+fila.data.numero+'_'+fila.data.extension;
                    if(telefonos=='')
                    	telefonos=t;
                    else
                    	telefonos+=','+t;
                }
                
                var datosAutor='{"idProceso":"100","sexo":"'+sexo+'","fechaNacimiento":"'+gEx('dteFechaNac').getValue().format('Y-m-d')+
                				'","prefijo":"'+cv(prefijo)+'","idProceso":"0","apPaterno":"'+cv(apPaterno)+
                			'","apMaterno":"'+cv(apMaterno)+'","nombres":"'+cv(nombre)+'","email":"'+cv(mail)+'","codInstitucion":"'+cv(codInstitucion)+
                            '","codDepto":"'+cv(codInstitucion)+'","telefonos":"'+telefonos+
                            '","direccion":{"calle":"'+gEx('txtCalle').getValue()+'","noInt":"'+gEx('txtNoInt').getValue()+'","noExt":"'+gEx('txtNoExt').getValue()+
                            '","colonia":"'+gEx('txtColonia').getValue()+'","cp":"'+gEx('txtCP').getValue()+'","estado":"'+gEx('cmbEstado').getValue()+'","municipio":"'+
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
                obtenerDatosWeb("../paginasFunciones/funcionesModulosEspeciales_SICORE.php",funcGuardar,'POST','funcion=207&'+'datosAutor='+datosAutor,true);//33
            }
        }
        else
        {
        	if(arrResp[0]==2)
            {
            	msgBox('La direcci&oacute;n de correo electr&oacute;nico ingresada ya ha sido registrada previamente');
            }
            else
            	msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=192&mail='+cv(mail),true);
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
		msgBox('El campo Ap. Paterno  es obligatorio',funcAceptar2);
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
    
    if((rdoHombre.getValue()=='')&&(rdoMujer.getValue()==''))
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
    	msgBox('El campo Estado es obligatorio',resp5);
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