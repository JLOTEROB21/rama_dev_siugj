<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT idTipoTelefono,tipoTelefono FROM 1006_tipoTelefono";
	$arrTelefonos=$con->obtenerFilasArreglo($consulta);
	
?>
var arrTelefonos=<?php echo $arrTelefonos?>;

Ext.onReady(inicializar);

function inicializar()
{


	

	gE('txtNombre').focus();
	crearCampoFecha('dteFechaNac','hFechaNac');
    crearGridTelefonoContacto();
}


function agregarAutor()
{

	var mail=gE('txtMail').value;
    var mail2=gE('txtMail2').value;
	if(!validarCorreo(mail))
	{
		function funcAceptar2()
		{
			gE('txtMail').focus();
			
		}
		Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','La direcci&oacute;n de correo electr&oacute;nico ingresada no es v&aacute;lida',funcAceptar2);
		return;
	}

	if(mail!=mail2)
    {
    	function respMail()
        {
        	gE('txtMail').focus();
        }
    	msgBox('Las direcciones de correo electr&oacute;nico ingresadas no coinciden',respMail);
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
                var apPaterno=gE('txtApPaterno').value;
                var apMaterno=gE('txtApMaterno').value;
                var nombre=gE('txtNombre').value;
                var mail=gE('txtMail').value;
                var txtCodInst=gE('codInstitucion');
                var codInstitucion='';
                var codDepto='';
                if(txtCodInst!=null)
                {
                    codInstitucion=txtCodInst.value;
                    codDepto=codInstitucion;
                    var nDiv=1;
                    var cmbDiv;
                    while(true)
                    {
                        cmbDiv=gE('cmbDiv_'+nDiv);
                        if((cmbDiv==null)||(cmbDiv.selectedIndex==0))
                            break;
                        codDepto=cmbDiv.options[cmbDiv.selectedIndex].value;
                        nDiv++;                    	
                    }
                }
                else
                {
                	codInstitucion=gE('codInstitucionConv').value;
                }
                var idProceso=gE('idProceso').value;
                var prefijo=gE('txtPrefijo').value;
                var sexo=0;
                if(gE('sexoF').checked)
                	sexo=1;
                var datosAutor='{"sexo":"'+sexo+'","prefijo":"'+cv(prefijo)+'","idProceso":"'+idProceso+'","apPaterno":"'+cv(apPaterno)+'","apMaterno":"'+cv(apMaterno)+'","nombres":"'+cv(nombre)+'","email":"'+cv(mail)+'","codInstitucion":"'+cv(codInstitucion)+'","codDepto":"'+cv(codDepto)+'"}';
                
                alert(datosAutor);
                return;
                function funcGuardar()
                {
                    var arrResp=peticion_http.responseText.split("|");
                    if(arrResp[0]=='1')
                    {
                    	function respMail()
                        {
                        	//location.href="../principal/inicio.php";
                            if(window.parent.cerrarVentanaFancy!=undefined)
                            	window.parent.cerrarVentanaFancy();
                        }
                     	msgBox('Su cuenta ha sido registrada de manera exitosa, en breve recibir&aacute; un correo electr&oacute;nico con sus datos de acceso',respMail);   
                        return;
                    }
                    else
                        msgBox('<?php echo $etj["errOperacion"].' '?>'+arrResp[0]);
                }
                obtenerDatosWeb("../paginasFunciones/funcionesProyectos.php",funcGuardar,'POST','funcion=194&'+'datosAutor='+datosAutor,true);//33
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
	var nombre=gE('txtNombre').value;
	if(trim(nombre)=='')
	{
		function funcAceptar()
		{
			gE('txtNombre').focus();
			
		}
		Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','El campo nombre  es obligatorio',funcAceptar);
		return false;
	}
	
    var dteFechaNac=gEx('f_dteFechaNac');
    if(dteFechaNac.getValue()=='')
    {
    	msgBox('La fecha de nacimiento es obligatoria');
    	return;
    }
	
    
    var codInstitucion=gE('codInstitucion');
    if(codInstitucion!=null)
    {
        if(codInstitucion.value=='')
        {
            function funcAceptar3()
            {
                Ext.getCmp('cmbInstitucion').focus();
                
            }
            Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','La instituci&oacute;n seleccionada no es v&aacute;lida',funcAceptar3);
            return false;
        }
    }
    var chkAcepto=gE('chkAcepto');
    if(chkAcepto!=null)
    {
    	if(!chkAcepto.checked)
        {
        	msgBox('Usted debe leer y aceptar las normas del sitio');
            return false;
        }
    }
	return true;
}

function buscarMunicipio(cmb)
{
	var valor=cmb.options[cmb.selectedIndex].value;
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var arrMunicipios=eval(arrResp[1]);
            llenarCombo(gE('cmbMunicipio'),arrMunicipios,true);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcAjax, 'POST','funcion=29&cveEstado='+valor,true);
    
    
    
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
                                                            renderTo:'gTelefono',
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            clicksToEdit:1,
                                                            loadMask:true,
                                                            stripeRows :true,                                                            
                                                            columnLines : true,
                                                            height:120,
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

function mostrarTab(n,accion)
{
	var validacion=true;
    var tipoFuncion=eval("typeof(funcionValidacion_"+(n-1)+");");

    if((tipoFuncion!='undefined')&&(accion==1))
    {
    	eval('validacion=funcionValidacion_'+(n-1)+'();');
    }
    if(validacion)
    {
        var x;
        for(x=1;x<5;x++)
        {
            if(x==n)
            {
                mE('paso_'+x);
                if(gE('paso_'+x).getAttribute('campoFocus'))
                {
                	gE(gE('paso_'+x).getAttribute('campoFocus')).focus();
                }
            }
            else
                oE('paso_'+x);
            
    	}
    }
}

function funcionValidacion_1()
{
	var txtApPaterno=gE('txtApPaterno');
    var txtNombre=gE('txtNombre');
    var txtMail=gE('txtMail');
    var txtMail2=gE('txtMail2');
    var f_dteFechaNac=gEx('f_dteFechaNac');
    var txtNoIdentificacion=gE('txtNoIdentificacion');
	var cmbTipoIdentificacion=gE('cmbTipoIdentificacion');
    
	if(txtNombre.value=='')
    {
    	function resp2()
        {
        	txtNombre.focus();
        }
        msgBox('Debe ingresar el nombre',resp2);
        return false;
    }

    if(txtApPaterno.value=='')
    {
    	function resp()
        {
        	txtApPaterno.focus();
        }
        msgBox('Debe ingresar el apellido paterno',resp);
        return false;
    }
    
   
    
    if(txtMail.value=='')
    {
    	function resp3()
        {
        	txtMail.focus();
        }
        msgBox('Debe ingresar la direcci&oacute;n de correo electr&oacute;nico',resp3);
        return false;
    }
    
    if(!validarCorreo(txtMail.value))
    {
    	function resp6()
        {
        	txtMail.focus();
        }
        msgBox('La direcci&oacute;n de correo electr&oacute;nico ingresada NO es v&aacute;lida',resp6);
        return false;
    }
    
    if(txtMail.value!=txtMail2.value)
    {
    	function resp4()
        {
        	txtMail2.focus();
        }
        msgBox('La direcci&oacute;n de correo electr&oacute;nico ingresada NO coincide',resp4);
        return false;
    }
    
    
    
 	if(f_dteFechaNac.getValue()=='')
    {
    	function resp5()
        {
        	f_dteFechaNac.focus();
        }
        msgBox('Debe ingresar la fecha de nacimiento',resp5);
        return false;
    }   
    
    var tIdentificacion=cmbTipoIdentificacion.options[cmbTipoIdentificacion.selectedIndex].value;
    if(tIdentificacion!='-1')
    {
    	if(txtNoIdentificacion.value=='')
        {
            function resp7()
            {
                txtNoIdentificacion.focus();
            }
            msgBox('Debe ingresar n&uacute;mero de identificaci&oacute;n',resp7);
            return false;
        }
    	
    }
    
    
    return true;
}

function funcionValidacion_2()
{
	var gTelefonos=gEx('gTelefonos');
    if(gTelefonos.getStore().getCount()==0)
    {
    	function resp1()
        {
        	
        }
        msgBox('Debe ingresar almenos un tel&eacute;fono de contacto',resp1);
        return false;
    }
    var fila;
    var x;
    for(x=0;x<gTelefonos.getStore().getCount();x++)
    {
    	fila=gTelefonos.getStore().getAt(x);
        if(fila.data.tipoTelefono=='')
        {
        	function resp2()
            {
            	gTelefonos.startEditing(x,1);
            }
            msgBox('Debe indicar el tipo de tel&eacute;fono a agregar',resp2);
        	return false;
        }
        
        if(fila.data.numero=='')
        {
        	function resp3()
            {
            	gTelefonos.startEditing(x,3);
            }
            msgBox('Debe indicar el n&uacute;mero de tel&eacute;fono a agregar',resp3);
        	return false;
        }
    }
    
    return true;
}

function funcionValidacion_3()
{
	var txtProfesion=gE('txtProfesion');
    if(txtProfesion.value=='')
    {
    	function resp1()
        {
        	txtProfesion.focus();
        }
        msgBox('Debe ingresar su profesi&oacute;n',resp1);
        return false;
    }
    return true;
}

function tipoIdentificacionSel(cmbTipoIdentificacion)
{
	var tIdentificacion=cmbTipoIdentificacion.options[cmbTipoIdentificacion.selectedIndex].value;
    if(tIdentificacion=='-1')
    {
    	gE('txtNoIdentificacion').disabled=true;
        gE('lblOblIdentificacion').innerHTML='';
    }
    else
    {
	    gE('txtNoIdentificacion').disabled=false;
        gE('txtNoIdentificacion').focus();
        gE('lblOblIdentificacion').innerHTML='*';
    }
}

function crearCuentaUsuario()
{
	var chkAcepto=gE('chkAcepto');
    
    if(!chkAcepto.checked)
    {
    	msgBox('Primero debe aceptar los t&eacute;rminos y condiciones del sitio');
    	return;
    }
    
	var txtApPaterno=gE('txtApPaterno');
    var txtApMaterno=gE('txtApMaterno');
    var txtNombre=gE('txtNombre');
    var txtMail=gE('txtMail');
    var f_dteFechaNac=gEx('f_dteFechaNac');
    var sexoM=gE('sexoM');
    var txtNoIdentificacion=gE('txtNoIdentificacion');
	var cmbTipoIdentificacion=gE('cmbTipoIdentificacion');
    var tIdentificacion=cmbTipoIdentificacion.options[cmbTipoIdentificacion.selectedIndex].value;
    var txtCURP=gE('txtCURP');
    
    var txtCalle=gE('txtCalle');
    var txtNoExt=gE('txtNoExt');
    var txtNoInt=gE('txtNoInt');
    var txtColonia=gE('txtColonia');
    var txtCP=gE('txtCP');
    var cmbEstado=gE('cmbEstado');
    var cmbMunicipio=gE('cmbMunicipio');
    var estado=cmbEstado.options[cmbEstado.selectedIndex].value;
    var municipio=cmbMunicipio.options[cmbMunicipio.selectedIndex].value;
    var arrTelefonos='';
    var x;
    var gTelefonos=gEx('gTelefonos');
    var fila;
    var oTelefono='';
    for(x=0;x<gTelefonos.getStore().getCount();x++)
    {
    	fila=gTelefonos.getStore().getAt(x);
        oTelefono='{"tipoTelefono":"'+fila.data.tipoTelefono+'","lada":"'+fila.data.lada+'","numero":"'+fila.data.numero+
        		'","extension":"'+fila.data.extension+'"}';
        if(arrTelefonos=='')
        {
        	arrTelefonos=oTelefono;
        }
        else
        	arrTelefonos+=','+oTelefono;
    }
    
	var txtProfesion=gE('txtProfesion');
    var txtCedula=gE('txtCedula');
    var txtNombreDespacho=gE('txtNombreDespacho');
                                                                                                                        
    
    var cadObj='{"nombre":"'+cv(txtNombre.value)+'","apPaterno":"'+cv(txtApMaterno.value)+'","apMaterno":"'+cv(txtApMaterno.value)+
    '","mail":"'+cv(txtMail.value)+'","fechaNacimiento":"'+f_dteFechaNac.getValue().format('Y-m-d')+'","genero":"'+(sexoM.checked?1:0)+
    '","tipoIdentificacion":"'+tIdentificacion+'","noIdentificacion":"'+cv(txtNoIdentificacion.value)+'","curp":"'+cv(txtCURP.value)+
    '","calle":"'+cv(txtCalle.value)+'","noExt":"'+cv(txtNoExt.value)+'","noInt":"'+cv(txtNoInt.value)+'","colonia":"'+cv(txtColonia.value)+
    '","cp":"'+cv(txtCP.value)+'","estado":"'+estado+'","municipio":"'+municipio+'","telefonos":['+arrTelefonos+
    '],"profesion":"'+cv(txtProfesion.value)+'","cedulaProfesional":"'+cv(txtCedula.value)+'","nombreDespacho":"'+cv(txtNombreDespacho.value)+'"}';
    
  
  	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            function resp()
            {
            	if(window.parent.cerrarVentanaFancy)
	            	window.parent.cerrarVentanaFancy();
            }
            msgBox('Sus datos han sido registrados correctamente, en breve recibir&aacute; un correo electr&oacute;nico con sus datos de acceso',resp);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SICORE.php',funcAjax, 'POST','funcion=5&cadObj='+cadObj,true);
    
      
    
    
    
    
}