<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

Ext.onReady(inicializar);

function inicializar()
{
	var txtNormas=crearRichText('txtNormas','spTextoEnriquecido',700,400,'',bD(gE('txtNormas').value));
    txtNormas.on('editorRender',function(textEditor)
    							{
                                	var cmbSolicitar=gE('cmbSolicitar');
								    var sNormas=cmbSolicitar.options[cmbSolicitar.selectedIndex].value;
                                    if(sNormas=='0')
                                    	oE('spAceptacionNorma');
                                }
				)                                
    var cmbSolicitar=gE('cmbSolicitar');
  
}

function agregarRol()
{
	<?php
		$consulta="select concat(idRol,'_',extensionRol),nombreGrupo from 8001_roles where  idIdioma=".$_SESSION["leng"]." order by nombreGrupo";
		$arrRoles=uEJ($con->obtenerFilasArreglo($consulta));
	?>
    var arrRoles=<?php echo $arrRoles;?>;
    var cmbExtensiones=crearComboExt('cmbExtensiones',[],100,35,250);
	cmbExtensiones.hide();
	var cmbRoles=crearComboExt('cmbRoles',arrRoles,100,5,250);
    function rolSeleccionado(combo,registro,indice)
    {
    	cmbExtensiones.reset();
    	var idRegistro=registro.get('id');
        var arrId=idRegistro.split('_');
        if(arrId[1]!=0)
        {
        	function funcAjax()
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
					var arrExtensiones=eval(arrResp[1]);
                    cmbExtensiones.getStore().loadData(arrExtensiones);     
                    
                	cmbExtensiones.show();
		            Ext.getCmp('lblExtension').show();
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcAjax, 'POST','funcion=20&noTodos=true&extension='+arrId[1],true);
        
        	
        }
        else
        {
        	cmbExtensiones.hide();
            Ext.getCmp('lblExtension').hide();
        }
        
    }
    
    cmbRoles.on('select',rolSeleccionado);
    
	var form=new Ext.form.FormPanel(
										{
											baseCls: 'x-plain',
											layout:'absolute',
											disabled:false,
											items:
													[
													 	{
                                                        	id:'lblRol',
                                                            x:10,
                                                            y:10,
                                                            xtype:'label',
                                                            html:'Rol:'
                                                        },
                                                        cmbRoles,
                                                        {
                                                        	id:'lblExtension',
                                                        	x:10,
                                                            y:40,
                                                            xtype:'label',
                                                            html:'Extensi&oacute;n:',
                                                            hidden:true
                                                        },
                                                        cmbExtensiones
													]
										}
									)
	var ventana=new Ext.Window(
							   		{
										title:'Agregar rol',
										width:380,
										height:150,
										layout:'fit',
										buttonAlign:'center',
										items:[form],
										modal:true,
										plain:true,
										listeners:
											{
												show:
												{
													buffer:10,fn:function()
															{
																
															}
												}
											},
										buttons:
												[
												 	{
														text:'Aceptar',
														handler:function ()
															{
                                                            	var rol=cmbRoles.getValue();
                                                                var arrId=rol.split('_');
                                                                var extension='0';
                                                                if(arrId[1]!=0)
                                                                	extension=cmbExtensiones.getValue();	
                                                                if(extension=='')
                                                                {
                                                                	function resp()
                                                                    {
                                                                    	cmbExtensiones.focus();
                                                                    }
                                                                	Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','Debe seleccionar una extensi&oacute;n del rol',resp);
                                                                    return;
                                                                }
                                                                var listRoles=gE('listRoles');
                                                                var codigoRol=arrId[0]+'_'+extension;
                                                                var rolExiste=existeRol('listRoles',codigoRol);
                                                                
                                                                if(!rolExiste)
                                                                {
                                                                	
                                                                	var option=document.createElement('option');
                                                                    option.value=codigoRol;
                                                                    var nExtension=cmbExtensiones.getValue();
                                                                    var txtExtension='';
                                                                    if(nExtension!='')
                                                                    {
                                                                    	txtExtension=' ('+cmbExtensiones.getRawValue()+')';
                                                                    }
                                                                    option.text=cmbRoles.getRawValue()+txtExtension;
                                                                    listRoles.options[listRoles.options.length]=option;
                                                                }
                                                                
                                                                
                                                                ventana.close();
																
															}
													},
													{
														text:'Cancelar',
														handler:function ()
															{
																ventana.close();
															}
													}
												 ]
									}
							   )
	ventana.show();

}

function existeRol(idCombo,valor)
{
	var combo=gE(idCombo);
    var x;
    for(x=0;x<combo.options.length;x++)
    {
    	if(combo.options[x].value==valor)
        	return true;
    }
    return false;
}

function removerRol()
{
	var cmbRoles=gE('listRoles');
	var rol=cmbRoles.selectedIndex;
	if(rol==-1)
	{
		Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','Debe elegir el rol a remover');
        return;
	}
    function resp(btn)
    {
    	if(btn=='yes')
        	cmbRoles[cmbRoles.selectedIndex]=null;
    }
    Ext.MessageBox.confirm('<?php echo $etj["lblAplicacion"]?>','Est&aacute; seguro de querer remover este rol',resp);
}

function solicitarAceptacion(ctrl)
{
	if(ctrl.options[ctrl.selectedIndex].value=='0')
    	oE('spAceptacionNorma');
    else
    	mE('spAceptacionNorma');
}

function guardarConf()
{
	var txtTitulo=gE('txtTitulo');
    var cmbDatosAfiliacion=gE('cmbDatosAfiliacion');
    var sAfiliacion=cmbDatosAfiliacion.options[cmbDatosAfiliacion.selectedIndex].value;
    var cmbSolicitar=gE('cmbSolicitar');
    var sNormas=cmbSolicitar.options[cmbSolicitar.selectedIndex].value;
    var normas='';
    if(sNormas=='1')
		normas=gEx('txtNormas').getValue();
    var listRoles=gE('listRoles');
    var lRoles=recoletarValoresCombo(listRoles);

	if(txtTitulo.value=='')
    {
    	function funcTitulo()
        {
        	txtTitulo.focus();
        }
    	msgBox('Es t&iacute;tulo del proceso es obligatorio',funcTitulo);
        return;
    }
	if((sNormas=='1')&&(normas==''))
    {
		function funcNormas()
        {
        	var editor=Ext.getCmp('txtNormas').getInnerEditor();
			editor.Focus();
        }
    	msgBox('Debe indicar las normas que el nuevo usuario deber&aacute; aceptar ',funcNormas);
        return;
    	
    }	
    var idProceso=gE('idProceso').value;
	var obj='{"idProceso":"'+idProceso+'","txtTitulo":"'+cv(txtTitulo.value)+'","sAfiliacion":"'+sAfiliacion+'","sNormas":"'+sNormas+'","normas":"'+(cv(normas))+'","listRoles":"'+lRoles+'"}';
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	msgBox('La configuraci&oacute;n ha sido guardada correctamente');
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=193&obj='+obj,true);
  
}

function configurarMail(iC)
{

	function resp(btn)
    {
    
    	if(btn=='yes')
        {
			var idProceso=gE('idProceso').value;
            var arrParam=[['idCircular',bD(iC)],['idProceso',idProceso],['nEtapa','1']];
            enviarFormularioDatos('../mensajesAccion/mensajesAccion.php',arrParam);        
        }
    }
    msgConfirm('Se recomienda guardar la configuraci&oacute;n del proceso antes de configurar el correo de activaci&oacute;n, desea continuar de todas formas?',resp);
	
}