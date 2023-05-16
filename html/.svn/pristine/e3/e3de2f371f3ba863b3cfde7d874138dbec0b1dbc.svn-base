<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

function validarFrm()
{
	if(validarFormularios('frmEnvio'))
    {
    	var listRoles=gE('listRoles');
        var x;
        var objArr='';
        for(x=0;x<listRoles.options.length;x++)
        {
        	obj='{"idRol":"'+listRoles.options[x].value+'"}';
            if(objArr=='')
            	objArr=obj;
            else
            	objArr+=','+obj;
        }
    	var objArr='{"arrRoles":['+objArr+']}';
        var id=gE('id').value;
        if(id=='-1')
        {
            gE('funcPHPEjecutarNuevo').value=bE('asociarRolesCategoriasOrganigrama(@idRegPadre,\''+bE(objArr)+'\')');
        }
        else
        {
            gE('funcPHPEjecutarModif').value=bE('asociarRolesCategoriasOrganigrama('+id+',\''+bE(objArr)+'\')');
        }
        gE('frmEnvio').submit();
	}     
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
                                                                	msgBox('Debe seleccionar una extensi&oacute;n del rol',resp);
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
                                                                else
                                                                {
                                                                	msgBox('El Rol seleccionado ya ha sido agregado anteriormente')
                                                                    return;
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
		msgBox('Debe elegir el rol a remover');
        return;
	}
    
    function resp(btn)
    {
    	if(btn=='yes')
        	cmbRoles[cmbRoles.selectedIndex]=null;
    }
    msgConfirm('Est&aacute; seguro de querer remover este rol',resp);
    
    
}