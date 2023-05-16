<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$consulta="SELECT cveEstado,estado FROM 820_estados ORDER BY estado";
	$arrEstados=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idTipoTelefono,tipoTelefono FROM 1006_tipoTelefono";
	$arrTelefonos=$con->obtenerFilasArreglo($consulta);
	
	$idFormulario=-1;
	$idRegistro=-1;
	
	if(isset($_GET["iF"]))
	{
		$idFormulario=$_GET["iF"];
		$idRegistro=$_GET["iR"];
	}
	
	
?>

var arrTelefonos=<?php echo $arrTelefonos?>;
var arrEstados=<?php echo $arrEstados?>;
var oDatosContacto;
var oConfRenderer;
var idParticipanteContacto=-1;


function construirTableroDireccion(objConfRenderer)
{
	oConfRenderer=objConfRenderer;
	idParticipanteContacto=objConfRenderer.idParticipante;    
    if(idParticipanteContacto==-1)
    {
    	gE(objConfRenderer.renderTo).innerHTML='';
        return;
    }    
    
    if(typeof(obtenerDatosWebV2)=='undefined')
    {
        loadScript('../Scripts/funcionesAjaxV2.js', function()
                                                    {
                                                    	consultarDatosContacto(objConfRenderer);
                                                    }
                    );
	}
    else
    {
    	consultarDatosContacto(objConfRenderer);
    }
    
    
    
	
    
    
}


function consultarDatosContacto(objConfRenderer)
{

	function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	
        	oDatosContacto=eval('['+arrResp[1]+']')[0];
        	var telefonos='';
            var x;
            var o;
            var e;
            if(oDatosContacto.telefonos.length>0)
            {
            	telefonos='<table>';
            	for(x=0;x<oDatosContacto.telefonos.length;x++)	
                {
                	o=oDatosContacto.telefonos[x];
                    e='<tr><td>['+(o.tipoTelefono=='1'?'Fijo':'Celular')+'] ('+o.lada+') '+o.numero+' '+(o.extension!=''?'Ext. '+o.extension:'')+'</td></tr>'
                	telefonos+=e;
                }
                telefonos+='</table>';
            }
            
            var email='';
            
            if(oDatosContacto.correos.length>0)
            {
            	email='<table>';
            	for(x=0;x<oDatosContacto.correos.length;x++)	
                {
                	o=oDatosContacto.correos[x];
                    e='<tr><td>'+o.mail+'</td></tr>'
                	email+=e;
                }
                email+='</table>';
            }
            
            
            var lblEditar='';
            
            if(objConfRenderer.permiteEditar)
            	lblEditar='<a href="javascript:editarDatosContacto()" style="font-size:11px"><img src="../images/pencil.png" width="14" height="14"> [Editar datos de contacto]</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            
            var tabla='<table >'+
                        '<tr>'+
                            '<td colspan="6" class="SeparadorSeccion" width="850">Datos de contacto</td>'+
                        '</tr>'+
                        '<tr height="30">'+
                            '<td  class="" width="150" colspan="6" align="right">'+lblEditar+'</td><td  class="TSJDF_Control" width="700" align="left"></td>'+
                        '</tr>'+
                        '<tr height="21">'+
                            '<td >'+
                                '<table width="920">'+
                                    '<tr>'+
                                        '<td  class="TSJDF_Etiqueta" width="100">Calle:</td><td  class="TSJDF_Control"  width="450">'+oDatosContacto.calle+'</td>'+
                                        '<td  class="TSJDF_Etiqueta" width="70">No. Ext.:</td><td  class="TSJDF_Control"  width="300">'+oDatosContacto.noExt+'</td>'+
                                    '</tr>'+
                                '</table>'+
                             '</td>'+
                        '</tr>'+
                        '<tr height="21">'+
                            '<td >'+
                                '<table width="770">'+
                                    '<tr>'+
                                        '<td  class="TSJDF_Etiqueta" width="100">No. Int:</td><td  class="TSJDF_Control"  width="150">'+oDatosContacto.noInt+'</td>'+
                                        '<td  class="TSJDF_Etiqueta" width="70">Colonia:</td><td  class="TSJDF_Control"  width="230">'+oDatosContacto.colonia+'</td>'+
                                        '<td  class="TSJDF_Etiqueta" width="70">C.P.:</td><td  class="TSJDF_Control"  width="150">'+oDatosContacto.cp+'</td>'+
                                    '</tr>'+
                                '</table>'+
                             '</td>'+
                        '</tr>'+
                        '<tr height="21">'+
                            '<td >'+
                                '<table width="770">'+
                                    '<tr>'+
                                        '<td  class="TSJDF_Etiqueta" width="100">Estado:</td><td  class="TSJDF_Control"  width="150" id="lblEstado">'+oDatosContacto.lblEstado+'</td>'+
                                        '<td  class="TSJDF_Etiqueta" width="70">Municipio:</td><td  class="TSJDF_Control"  width="230">'+oDatosContacto.lblMunicipio+'</td>'+
                                        '<td  class="TSJDF_Etiqueta" width="70">Localidad:</td><td  class="TSJDF_Control"  width="150">'+oDatosContacto.localidad+'</td>'+
                                    '</tr>'+
                                '</table>'+
                             '</td>'+
                        '</tr>'+
                        '<tr height="21">'+
                            '<td >'+
                                '<table width="840">'+
                                    '<tr>'+
                                        '<td  class="TSJDF_Etiqueta" width="100">Entre la calle:</td><td  class="TSJDF_Control"  width="330">'+oDatosContacto.entreCalle+'</td>'+
                                        '<td  class="TSJDF_Etiqueta" width="70">y la calle:</td><td  class="TSJDF_Control"  width="340">'+oDatosContacto.yCalle+'</td>'+
                                        
                                    '</tr>'+
                                '</table>'+
                             '</td>'+
                        '</tr>'+
                        '<tr height="21">'+
                            '<td >'+
                                '<table width="840">'+
                                    '<tr>'+
                                        '<td  class="TSJDF_Etiqueta" width="140" valign="top">Otras referencias:</td><td  class="TSJDF_Control"  width="700">'+oDatosContacto.referencias+'</td>'+
                                    '</tr>'+
                                '</table>'+
                             '</td>'+
                        '</tr>'+
                        '<tr height="21">'+
                            '<td ><br><br>'+
                                '<table width="840">'+
                                    '<tr>'+
                                        '<td  class="TSJDF_Etiqueta" width="420">'+
                                        '<fieldset style="width:410px; min-height:100px; padding:10px"> <legend>Tel&eacute;fonos</legend><span class="TSJDF_Control">'+telefonos+'</span></fieldset>'+
                                        '</td>'+
                                        '<td  class="TSJDF_Etiqueta"  width="420">'+
                                        '<fieldset style="width:410px; min-height:100px; padding:10px"> <legend>Correo electr&oacute;nico</legend><span class="TSJDF_Control">'+email+'</span></fieldset>'+
                                        '</td>'+
                                    '</tr>'+
                                '</table>'+
                             '</td>'+
                        '</tr>'+
                        '</table>';
        
        
        	gE(objConfRenderer.renderTo).innerHTML=tabla;
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=116&idParticipante='+idParticipanteContacto,true);


	
}

function editarDatosContacto()
{
	var cmbEstado=crearComboExt('cmbEstado',arrEstados,70,65,170);
    cmbEstado.on('select',obtenerMunicipios);
    cmbEstado.setValue(oDatosContacto.estado);
    var cmbMunicipio=crearComboExt('cmbMunicipio',[],320,65,180);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
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
                                                            id:'txtCalle',
                                                            value:oDatosContacto.calle
                                                        },
                                                        {
                                                        	x:510,
                                                            y:10,
                                                            html:'No. Ext:'
                                                        },
                                                        {
                                                        	x:570,
                                                            y:5,
                                                            xtype:'textfield',
                                                            width:120,
                                                            id:'txtNoExt',
                                                            value:oDatosContacto.noExt
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
                                                            id:'txtNoInt',
                                                            value:oDatosContacto.noInt
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
                                                            id:'txtColonia',
                                                            value:oDatosContacto.colonia
                                                        },
                                                        {
                                                        	x:510,
                                                            y:40,
                                                            html:'C.P.:'
                                                        },
                                                        {
                                                        	x:570,
                                                            y:35,
                                                            xtype:'textfield',
                                                            width:100,
                                                            id:'txtCP',
                                                            value:oDatosContacto.cp
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
                                                        	x:570,
                                                            y:65,
                                                            xtype:'textfield',
                                                            width:160,
                                                            id:'txtLocalidad',
                                                            value:oDatosContacto.localidad
                                                        },
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            html:'Entre la calle:'
                                                        },
                                                        {
                                                        	x:95,
                                                            y:95,
                                                            xtype:'textfield',
                                                            width:270,
                                                            id:'txtEntreCalle',
                                                            value:oDatosContacto.entreCalle
                                                        },
                                                        {
                                                        	x:385,
                                                            y:100,
                                                            html:'y la calle:'
                                                        },
                                                        {
                                                        	x:450,
                                                            y:95,
                                                            xtype:'textfield',
                                                            width:280,
                                                            id:'txtYCalle',
                                                            value:oDatosContacto.yCalle
                                                        },
                                                        {
                                                        	x:10,
                                                            y:130,
                                                            html:'Otras referencias:'
                                                        },
                                                        {
                                                        	x:120,
                                                            y:125,
                                                            xtype:'textarea',
                                                            width:610,
                                                            height:40,
                                                            id:'txtReferencias',
                                                            value:escaparBR(oDatosContacto.referencias,true)
                                                        },
                                                        crearGridTelefono(),
                                                        crearGridMail()
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Modificar datos de contacto',
										width: 770,
										height:430,
										layout: 'fit',
										plain:true,
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
                                        				close: function()
                                                        		{
                                                                	if(oConfRenderer.afterCloseWindow)
                                                                    	oConfRenderer.afterCloseWindow();
                                                                },
                                                        beforeclose: function()
                                                        		{
                                                                	if(oConfRenderer.beforeCloseWindow)
                                                                    	oConfRenderer.beforeCloseWindow();
                                                                },
                                                        beforeshow : function()
                                                        			{
                                                                    	if(oConfRenderer.beforeShowWindow)
                                                                        	oConfRenderer.beforeShowWindow();
                                                                    },
														show : {
                                                                    buffer : 10,
                                                                    fn : function() 
                                                                    {
                                                                        gEx('txtCalle').focus(false,500);
                                                                        
                                                                        if(oConfRenderer.afterShowWindow)
                                                                            oConfRenderer.afterShowWindow();
                                                                        
                                                                    }
                                                                }
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',                                                            
															handler: function()
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
                                                                                    '],"mail":['+arrMail+'],"idFormulario":"<?php echo $idFormulario?>",'+
                                                                                    '"idRegistro":"<?php echo $idRegistro?>","idParticipante":"'+idParticipanteContacto+'"}';
                                                                    	
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	consultarDatosContacto(oConfRenderer);
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=117&cadObj='+cadObj,true);
                                                                        
                                                                    
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
    
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var arrDatos=eval(arrResp[1]);
            
            gEx('cmbMunicipio').getStore().loadData(arrDatos);
            gEx('cmbMunicipio').setValue(oDatosContacto.municipio);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=89&cveEstado='+oDatosContacto.estado,true);
    
    var regTelefono=crearRegistro	(
                                        [
                                            {name: 'tipoTelefono'},
                                            {name: 'lada'},
                                            {name: 'numero'},
                                            {name: 'extension'}
                                        ]
                                    )
    
	var x;
    var r;
    for(x=0;x<oDatosContacto.telefonos.length;x++)
    {
		 r=new regTelefono	(
                               oDatosContacto.telefonos[x]
                            )
         gEx('gTelefonos').getStore().add(r);
	}
    
    var regMail=crearRegistro	(
    								[
                                    	{name: 'mail'}
                                    ]
    							)
    
    for(x=0;x<oDatosContacto.correos.length;x++)
    {
		 r=new regMail	(
                           oDatosContacto.correos[x]
                        )
         gEx('gMail').getStore().add(r);
	}
    
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
                                                            y:180,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,                                                            
                                                            columnLines : true,
                                                            height:165,
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
                                                            y:180,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,                                                            
                                                            columnLines : true,
                                                            height:165,
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
                                                                                    	var fila=gEx('gTelefonos').getSelectionModel().getSelected();
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