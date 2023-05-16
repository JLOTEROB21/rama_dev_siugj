<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="select idPais,nombre from 238_paises order by nombre";
	$arrPaises=uEJ($con->obtenerFilasArreglo($consulta));
	
	$consulta="SELECT id__407_tablaDinamica,turno FROM _407_tablaDinamica WHERE id__407_tablaDinamica<>8 ORDER BY turno";
	$arrTurnos=$con->obtenerFilasArreglo($consulta);
	$consulta="SELECT cveEstado,estado FROM 820_estadosV2 ORDER BY estado";
	$arrEstados=$con->obtenerFilasArreglo($consulta);
?>
var arrEstados=<?php echo $arrEstados?>;
var arrTurnos=<?php echo $arrTurnos?>;

Ext.onReady(inicializar);

function inicializar()
{
	gE('noGrupos').focus();
	
    var combo;
    var obj={};
    obj.renderTo='dEstado',
    combo=crearComboExt('cEstado',eval(bD(gE('arrEstado').value)),0,0,200,obj);
    combo.on('select',function(cmb,registro)
    					{
                        	estadoSel(registro.data.id);
                        }
    		)
    obj={};
    obj.renderTo='dMunicipio',
    combo=crearComboExt('cMunicipio',[],0,0,200,obj);
    combo.on('select',function(cmb,registro)
    					{
                        	municipioSel(registro.data.id);
                        }
    		)
    obj={};
    obj.renderTo='dLocalidad',
    combo=crearComboExt('cLocalidad',[],0,0,200,obj);
    combo.on('select',function(cmb,registro)
    					{
                        	localidadSel(registro.data.id);
                        }
    		)
    obj={};
    obj.renderTo='dPlantel',
    obj.confVista='<tpl for="."><div class="search-item">{nombre}<br /><b>Direcci&oacute;n:</b> {valorComp}<br />----</div></tpl>';
    combo=crearComboExt('cPlantel',[],0,0,400,obj);
    combo.on('select',function(cmb,registro)
    					{
                        	plantelSel(registro.data.id);
                        }
    		)
    obj={};
    obj.renderTo='dTurno',
    crearComboExt('cTurno',[],0,0,200,obj);
   
}

function agregarAutor()
{
	var apPaterno=gE('txtApPaterno');
    var apMaterno=gE('txtApMaterno');
    var nombre=gE('txtNombre');
    var noGrupos=gE('noGrupos');
   
    var cmbPlantel=gEx('cPlantel');
 	var idPlantel=cmbPlantel.getValue();
    
    var cmbTurno=gEx('cTurno');
 	var idTurno=cmbTurno.getValue();

	if(noGrupos.value.trim()=='')
    {
    	function resp101010()
        {
        	noGrupos.focus();
        }
        msgBox('Debe especificar el n&uacute;mero de grupos que participarán en el curso',resp101010);
        return;
    }

    if(apPaterno.value.trim()=='')
    {
    	function resp10()
        {
        	apPaterno.focus();
        }
        msgBox('Debe ingresar su apellido paterno',resp10);
        return;
    }
    
    if(nombre.value.trim()=='')
    {
    	function resp11()
        {
        	nombre.focus();
        }
        msgBox('Debe ingresar su nombre',resp11);
        return;
    }
    
    
    var txtTelefono=gE('txtTelefono');
    var txtTelefonoMovil=gE('txtTelefonoMovil');
    
    if((txtTelefonoMovil.value.trim()=='')&&(txtTelefono.value.trim()==''))
    {
    	function resp1000()
        {
        	txtTelefono.focus();
        }
    	msgBox('Al menos debe ingresar un tel&eacute;fono de contacto (Tel&eacute;fono de casa o m&oacute;vil)',resp1000);
    	return;
    }
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
	
    if(idPlantel=='')
    {
    	function resp100()
        {
        	cmbPlantel.focus();
        }
        msgBox('Debe indicar su plantel de origen',resp100);
        return;
    }
    
    if(idTurno=='')
    {
    	function resp101()
        {
        	cmbTurno.focus();
        }
        msgBox('Debe indicar el turno de su plantel al cual asiste',resp101);
        return;
    }    
    
    var apPaternoD=gE('txtApPaternoD');
    var apMaternoD=gE('txtApMaternoD');
    var nombreD=gE('txtNombreD');
    
    if(apPaternoD.value.trim()=='')
    {
    	function resp1001()
        {
        	apPaternoD.focus();
        }
        msgBox('Debe ingresar el apellido paterno del diector del plantel',resp1001);
        return;
    }
    
    if(nombreD.value.trim()=='')
    {
    	function resp1002()
        {
        	nombreD.focus();
        }
        msgBox('Debe ingresar el nombre del diector del plantel',resp1002);
        return;
    }
        
    var txtTelefonoD=gE('txtTelefonoMovilD');
    
    if(txtTelefonoD.value.trim()=='')
    {
    	function resp1010()
        {
        	txtTelefonoD.focus();
        }
    	msgBox('Debe ingresar el tel&eacute;fono de contacto del director del plantel',resp1010);
    	return;
    }
    var mailD=gE('txtMailD').value;
    var mailD2=gE('txtMailD2').value;
    if(mailD!='')
    {
        if(!validarCorreo(mailD))
        {
            function funcAceptar2000()
            {
                gE('txtMailD').focus();
                
            }
            msgBox('La direcci&oacute;n de correo electr&oacute;nico del director del plantel ingresada no es v&aacute;lida',funcAceptar2000);
            return;
        }
	}
	if(mailD!=mailD2)
    {
    	function respMailD()
        {
        	gE('txtMailD').focus();
        }
    	msgBox('Las direcciones de correo electr&oacute;nico del director del plantel ingresadas no coinciden',respMailD);
    	return;
    }
    
    var cadObjDirector='{"apPaterno":"'+cv(apPaternoD.value)+'","apMaterno":"'+cv(apMaternoD.value)+'","nombre":"'+cv(nombreD.value)+'","telefono":"'+cv(txtTelefonoD.value)+'","email":"'+cv(mailD)+'"}';
    
    var sexo=0;
    if(gE('sexoF').checked)
        sexo=1;
                    
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
                var idProceso=gE('idProceso').value;
                var sexo=0;
                if(gE('sexoF').checked)
                	sexo=1;

                var datosAutor='{"noGrupos":"'+gE('noGrupos').value+'","tipoInscripcion":"'+gE('tipoInscripcion').value+'","sexo":"'+sexo+'","idProceso":"'+idProceso+'","apPaterno":"'+cv(apPaterno.value)+'","apMaterno":"'+cv(apMaterno.value)+'","nombres":"'+cv(nombre.value)+'","email":"'+cv(mail)+
                			'","fechaNacimiento":"","telCasa":"'+gE('txtTelefono').value+'","telMovil":"'+gE('txtTelefonoMovil').value+'","idProyecto":"'+gE('idProyecto').value+
                            '","idPlantel":"'+idPlantel+'","idTurno":"'+idTurno+'","datosContactoDirector":'+cadObjDirector+'}';
               
               
                function funcGuardar()
                {
                    var arrResp=peticion_http.responseText.split("|");
                    if(arrResp[0]=='1')
                    {
                    	function respMail()
                        {
                        	if(window.parent.cerrarVentanaFancy!=undefined)
                            {
                            	window.parent.cerrarVentanaFancy();

                            }
                            else
                            {
                            	window.parent.location.href=gE('pagRedireccion').value;
                            }
                        }
                     	msgBox('Su cuenta ha sido registrada de manera exitosa, en breve recibir&aacute; un correo electr&oacute;nico con sus datos de acceso.<br><span style="font-size:10px !important"><b>Si no recibe un e-mail de confirmaci&oacute;n, verifique en su buzón de correo no deseado</b></span>',respMail,null,'btnOk');   
                        return;
                    }
                    else
                        msgBox('<?php echo $etj["errOperacion"].' '?>'+arrResp[0]);
                }
                obtenerDatosWeb("../paginasFunciones/funcionesModulosEspeciales_Galileo.php",funcGuardar,'POST','funcion=34&'+'datosAutor='+datosAutor,true);//33
            
        }
        else
        {
        	if(arrResp[0]==2)
            {
            	msgBox('La direcci&oacute;n de correo electr&oacute;nico ingresada ya ha sido registrada previamente. <br /><br />Si ya se registr&oacute; anteriormente puede recuperar sus datos seleccionando la opción <b>Recuperar contraseña</b> en la secci&oacute;n "<b>Ingresar</b>"');
            }
            else
            	msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=192&mail='+cv(mail),true);
}

function estadoSel(estado)
{
	gEx('cMunicipio').reset();
    gEx('cMunicipio').getStore().removeAll();
    gEx('cLocalidad').reset();
    gEx('cLocalidad').getStore().removeAll();
    gEx('cPlantel').reset();
    gEx('cPlantel').getStore().removeAll();
    gEx('cTurno').reset();      
    gEx('cTurno').getStore().removeAll();
    obtenerMunicipioV2(estado,'cMunicipio',0,null,function()
    												{
														
                                                    	    //obtenerPlanteles(estado,1);
                                                    }
    					);

}

function municipioSel(municipio)
{
	
    gEx('cLocalidad').reset();
    gEx('cLocalidad').getStore().removeAll();
    gEx('cPlantel').reset();
    gEx('cPlantel').getStore().removeAll();
    gEx('cTurno').reset();      
    gEx('cTurno').getStore().removeAll();
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrDatos=eval(arrResp[1]);
          	gEx('cLocalidad').getStore().loadData(arrDatos);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Galileo.php',funcAjax, 'POST','funcion=43&tipoInscripcion='+gE('tipoInscripcion').value+'&idProyecto='+gE('idProyecto').value+'&codigo='+municipio,true);  

}

function localidadSel(localidad)
{
	
    gEx('cPlantel').reset();
    gEx('cPlantel').getStore().removeAll();
    gEx('cTurno').reset();      
    gEx('cTurno').getStore().removeAll();

    obtenerPlanteles(localidad,3);
}

function obtenerPlanteles(clave,tipo)
{
	
    gEx('cTurno').reset();      
    gEx('cTurno').getStore().removeAll();
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var arrDatos=eval(arrResp[1]);
            gEx('cPlantel').getStore().loadData(arrDatos);
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Galileo.php',funcAjax, 'POST','funcion=32&tipoBusqueda='+tipo+'&clave='+clave+'&idProyecto='+gE('idProyecto').value,true);

}

function plantelSel(valor)
{
	
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var arrDatos=eval(arrResp[1]);
            gEx('cTurno').getStore().loadData(arrDatos);
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Galileo.php',funcAjax, 'POST','funcion=33&plantel='+valor,true);
    
}

function buscarPorCCT()
{
	
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Ingrese el CCT de su plantel:'
                                                        },
                                                        {
                                                        	x:185,
                                                            y:10,
                                                            xtype:'textfield',
                                                            width:170,
                                                            id:'cct'
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Buscar plantel por CCT',
										width: 420,
										height:140,
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
                                                                	gEx('cct').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var cct=gEx('cct');
                                                                        if(cct.getValue()=='')	
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cct.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el CCT de plantel',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            switch(arrResp[0])
                                                                            {
                                                                             	case '1':
                                                                                	 var arrDatos=eval(arrResp[1]);
            																		gEx('cPlantel').getStore().loadData(arrDatos);
                                                                                    gEx('cPlantel').setValue(arrDatos[0][0]);
                                                                                    dispararEventoSelectCombo('cPlantel');
                                                                                	ventanaAM.close();
                                                                                break;
                                                                                case '2':
                                                                                	function respA()
                                                                                    {
                                                                                    	cct.focus(true);
                                                                                    }
                                                                                    msgBox('No se ha encontrado un plantel asociado al CCT ingresado',respA);
                                                                                    return;
                                                                                break;
                                                                                case '3':
                                                                                	function respB()
                                                                                    {
                                                                                    	cct.focus(true);
                                                                                    }
                                                                                    msgBox('S&oacute;lo pueden participar en este curso plateles ubicados en los estados de: '+arrResp[1],respB);
                                                                                    return;
                                                                                break; 
                                                                                case '4':
                                                                                	function respC()
                                                                                    {
                                                                                    	cct.focus(true);
                                                                                    }
                                                                                    msgBox('S&oacute;lo pueden participar en este curso plateles que ofrezcan servicios educativos de tipo: '+arrResp[1],respC);
                                                                                    return;
                                                                                break; 
                                                                                default:
                                                                                	msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                break;  
                                                                            }
                                                                            
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Galileo.php',funcAjax, 'POST','funcion=42&clave='+gEx('cct').getValue()+'&idProyecto='+gE('idProyecto').value,true);
                                                                        
                                                                        
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

function registrarPlantel()
{
	var cmbTurnoPlantel=crearComboExt('cmbTurnoPlantel',arrTurnos,150,70,250);
    var cmbEstado=crearComboExt('cmbEstado',arrEstados,90,70,250);
    cmbEstado.on('select',function(cmb,registro)
    						{
                            	obtenerMunicipioV2(registro.data.id,'cmbMunicipio',0,null);
                            }
    			)
    var cmbMunicipio=crearComboExt('cmbMunicipio',[],90,100,250);
    cmbMunicipio.on('select',function(cmb,registro)
    						{
                            	obtenerLocalidadV2(registro.data.id,'cmbLocalidad',0,null);
                            }
    			)
    var cmbLocalidad=crearComboExt('cmbLocalidad',[],90,130,250);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'CCT del plantel:'
                                                        },
                                                        {
                                                        	x:150,
                                                            y:10,
                                                            xtype:'textfield',
                                                            width:150,
                                                            id:'txtCCT',
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Nombre del plantel: <span style="color:#F00">*</span>'
                                                        },
                                                        {
                                                        	x:150,
                                                            y:40,
                                                            xtype:'textfield',
                                                            width:350,
                                                            id:'txtNombrePlantel',
                                                        },
                                                        
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            xtype:'fieldset',
                                                            width:565,
                                                            height:200,
                                                            title:'Domicilio del plantel',
                                                            layout:'absolute',
                                                            items:	[
                                                            			{
                                                                        	x:10,
                                                                            y:10,
                                                                            xtype:'label',
                                                                            html:'Calle: <span style="color:#F00">*</span>'
                                                                        },
                                                                        {
                                                                        	x:90,
                                                                            y:10,
                                                                            xtype:'textfield',
                                                                            width:225,
                                                                            id:'txtCalle'
                                                                        },
                                                                        {
                                                                        	x:350,
                                                                            y:10,
                                                                            xtype:'label',
                                                                            html:'No:'
                                                                        },
                                                                        {
                                                                        	x:400,
                                                                            y:10,
                                                                            xtype:'textfield',
                                                                            width:130,
                                                                            id:'txtNo'
                                                                        },
                                                                        {
                                                                        	x:10,
                                                                            y:40,
                                                                            xtype:'label',
                                                                            html:'Colonia:'
                                                                        },
                                                                        {
                                                                        	x:90,
                                                                            y:40,
                                                                            xtype:'textfield',
                                                                            width:225,
                                                                            id:'txtColonia'
                                                                        },
                                                                        {
                                                                        	x:350,
                                                                            y:40,
                                                                            xtype:'label',
                                                                            html:'C.P.:'
                                                                        },
                                                                         {
                                                                        	x:400,
                                                                            y:40,
                                                                            allowDecimals:false,
                                                                            allowNegative:false,
                                                                            xtype:'numberfield',
                                                                            width:130,
                                                                            id:'txtCP'
                                                                        },
                                                                        {
                                                                        	x:10,
                                                                            y:70,
                                                                            xtype:'label',
                                                                            html:'Estado: <span style="color:#F00">*</span>'
                                                                        },
                                                                        cmbEstado,
                                                                        {
                                                                        	x:10,
                                                                            y:100,
                                                                            xtype:'label',
                                                                            html:'Municipio: <span style="color:#F00">*</span>'
                                                                        }
                                                                        ,
                                                                        cmbMunicipio,
                                                                        {
                                                                        	x:10,
                                                                            y:130,
                                                                            xtype:'label',
                                                                            html:'Localidad: <span style="color:#F00">*</span>'
                                                                        },
                                                                        cmbLocalidad
                                                            		]
                                                               
                                                        },
                                                        {
                                                            x:10,
                                                            y:315,
                                                            html:'<span style="font-size:10px">Los campos marcados con asterisco(<span style="color:#F00">*</span>) son obligatorios</span>'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Registro de plantel',
										width: 630,
										height:435,
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
                                                                	gEx('txtCCT').focus(false,500);
                                                                    
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var txtCCT=gEx('txtCCT');
                                                                        var txtNombrePlantel=gEx('txtNombrePlantel');
                                                                        var txtCalle=gEx('txtCalle');
                                                                        var txtNo=gEx('txtNo');
                                                                        var txtColonia=gEx('txtColonia');
                                                                        var txtCP=gEx('txtCP');
                                                                        
                                                                        if(txtNombrePlantel.getValue().trim()=='')
                                                                        {
                                                                        	function resp()
                                                                            {	
                                                                            	txtNombrePlantel.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el nombre del plantel',resp);
                                                                            return;
                                                                            
                                                                        }
                                                                        
                                                                       
                                                                        
                                                                        if(txtCalle.getValue()=='')
                                                                        {
                                                                        	function resp3()
                                                                            {	
                                                                            	txtCalle.focus();
                                                                            }
                                                                            msgBox('Debe ingresar la calle donde se ubica el plantel',resp3);
                                                                            return;
                                                                            
                                                                        }
                                                                                                                                                
                                                                        if(cmbEstado.getValue()=='')
                                                                        {
                                                                        	function resp4()
                                                                            {	
                                                                            	cmbEstado.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el estado en el cual se ubica el plantel',resp4);
                                                                            return;
                                                                            
                                                                        }
                                                                        
                                                                        if(cmbMunicipio.getValue()=='')
                                                                        {
                                                                        	function resp5()
                                                                            {	
                                                                            	cmbMunicipio.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el municipio en el cual se ubica el plantel',resp5);
                                                                            return;
                                                                            
                                                                        }
                                                                        
                                                                        if(cmbLocalidad.getValue()=='')
                                                                        {
                                                                        	function resp6()
                                                                            {	
                                                                            	cmbLocalidad.focus();
                                                                            }
                                                                            msgBox('Debe ingresar la localidad en el cual se ubica el plantel',resp6);
                                                                            return;
                                                                            
                                                                        }
                                                                        
                                                                        var cadObj='{"etapa":"3","idProyecto":"'+gE('idProyecto').value+'","cct":"'+cv(gEx('txtCCT').getValue())+'","nombrePlantel":"'+cv(gEx('txtNombrePlantel').getValue())+
                                                                        			'","calle":"'+cv(txtCalle.getValue())+'","no":"'+cv(txtNo.getValue())+
                                                                                    '","colonia":"'+cv(txtColonia.getValue())+'","cp":"'+cv(txtCP.getValue())+'","estado":"'+cmbEstado.getValue()+'","municipio":"'+
                                                                                    cmbMunicipio.getValue()+'","localidad":"'+cmbLocalidad.getValue()+'"}';
                                                                        
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            switch(arrResp[0])
                                                                            {
                                                                            	case '1':
                                                                                	var arrDatos=eval(arrResp[1]);
                                                                                    gEx('cPlantel').getStore().loadData(arrDatos);
                                                                                    gEx('cPlantel').setValue(arrDatos[0][0]);
                                                                                    dispararEventoSelectCombo('cPlantel');
                                                                                    ventanaAM.close();
                                                                                break;
                                                                                case '2':
                                                                                	cadObj=cadObj.replace('"etapa":"3"','"etapa":"4"');
                                                                                    function respEscuela(btn)
                                                                                    {
                                                                                    	if(btn=='yes')
                                                                                        {
                                                                                        	var arrDatos=eval(arrResp[2]);
                                                                                            gEx('cPlantel').getStore().loadData(arrDatos);
                                                                                            gEx('cPlantel').setValue(arrDatos[0][0]);
                                                                                            dispararEventoSelectCombo('cPlantel');
                                                                                            ventanaAM.close();
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                        
                                                                                        	function funcAjax2()
                                                                                            {
                                                                                                var resp=peticion_http.responseText;
                                                                                                arrResp=resp.split('|');
                                                                                                switch(arrResp[0])
                                                                                                {
                                                                                                    case '1':
                                                                                                        var arrDatos=eval(arrResp[1]);
                                                                                                        gEx('cPlantel').getStore().loadData(arrDatos);
                                                                                                        gEx('cPlantel').setValue(arrDatos[0][0]);
                                                                                                        dispararEventoSelectCombo('cPlantel');
                                                                                                        ventanaAM.close();
                                                                                                    break;
                                                                                                    default:
                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                    break;
                                                                                                }
                                                                                            }
                                                                                            obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Galileo.php',funcAjax2, 'POST','funcion=44&cadObj='+cadObj,true); 
                                                                                        
                                                                                        
                                                                                        
                                                                                        }
                                                                                    }
                                                                                    msgConfirm('Se ha detectado que ya existe un plantel con el CCT ingresado, los datos del mismo son: <br /><br />'+arrResp[1]+'<br /><br />¿Es este su plantel?',respEscuela);
                                                                                break;
                                                                                default:
                                                                                	msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                break;
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Galileo.php',funcAjax, 'POST','funcion=44&cadObj='+cadObj,true);            
                                                                                    
                                                                        
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
