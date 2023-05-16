<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

Ext.onReady(inicializar);

var keyMap = new Ext.KeyMap(document, 
									{
										key: 13, 
										fn: funValidar,
										scope: this
									}
							);

function funValidar()
{
	validar('frmEnvio');
}

function inicializar()
{
	gE('_numEtapaint').focus();
}

function validarfrm(formulario)
{
	if(validarFormularios(formulario))
	{
    	prepararComboRoles();
		gE(formulario).submit();
	}
}

function regresar()
{
	gE('formRegresar').submit();	
}

function prepararComboRoles()
{
	var comboRoles=gE('listRoles');
    if(comboRoles!=null)
    {
        var hRoles=gE('listadoRoles');
        var x;
        var roles='';
        
        for(x=0;x<comboRoles.options.length;x++)
        {
            if(roles=='')
                roles=comboRoles.options[x].value;
            else
                roles+=','+comboRoles.options[x].value;
        }
        hRoles.value=roles;
    }
}

function validaRoles()
{
	var combo=gE('listRoles');
    if(combo.options.length==0)
    	return false;
    else
    	return true;
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

function agregarRol()
{

	<?php
		if(existeRol("'1_0'"))
			$consulta="select concat(idRol,'_',extensionRol),nombreGrupo from 8001_roles where  idIdioma=1 and situacion=1 order by nombreGrupo";
		else
			$consulta="select concat(idRol,'_',extensionRol),nombreGrupo from 8001_roles where vistosAdmin=1 and situacion=1 and idIdioma=1 order by nombreGrupo";
		$arrRoles=uEJ($con->obtenerFilasArreglo($consulta));
	?>
    var arrRoles=<?php echo $arrRoles;?>;
    var cmbExtensiones=crearComboExt('cmbExtensiones',[],100,35,250);
	cmbExtensiones.hide();
	
    
    
    var panelPermisos=new Ext.form.FieldSet (
                                                    {
                                                        x:10,
                                                        y:70,
                                                        width:600,
                                                        title:'Permisos asignados al rol',
                                                        cls:'frameSiugj',
                                                        layout:'absolute',
                                                        height:80,
                                                        items: [		
                                                                        {
                                                                            x:10,
                                                                            y:5,
                                                                            boxLabel: 'Consultar',
                                                                            name: 'publico',
                                                                            xtype:'checkbox',
                                                                            id:'chkConsultar',
                                                                            ctCls:'SIUGJ_Etiqueta',
                                                                            checked:true,
                                                                            disabled:true
                                                                            
                                                                        },				
                                                                        {
                                                                            x:160,
                                                                            y:5,
                                                                            ctCls:'SIUGJ_Etiqueta',
                                                                            boxLabel: 'Agregar',
                                                                            name: 'publico',
                                                                            xtype:'checkbox',
                                                                            id:'chkAgregar'
                                                                        },
                                                                        {
                                                                            x:310,
                                                                            y:5,
                                                                            ctCls:'SIUGJ_Etiqueta',
                                                                            boxLabel: 'Modificar',
                                                                            name: 'publico',
                                                                            xtype:'checkbox',
                                                                            id:'chkModificar'
                                                                        },
                                                                        
                                                                        {
                                                                            x:460,
                                                                            y:5,
                                                                            ctCls:'SIUGJ_Etiqueta',
                                                                            boxLabel: 'Eliminar',
                                                                            name: 'privado',
                                                                            xtype:'checkbox',
                                                                            id:'chkElminar'
                                                                        }
                                                                ]
                                                    }
                                                )
    
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
                                                            y:15,
                                                            cls:'SIUGJ_Etiqueta',
                                                            xtype:'label',
                                                            html:'Rol:'
                                                        },
                                                        {
                                                            x:100,
                                                            y:10,
                                                            xtype:'label',
                                                            html:'<div id="divComboRol"></div>'
                                                        },
                                                        
                                                        panelPermisos
													]
										}
									)
	var ventana=new Ext.Window(
							   		{
										title:'Agregar rol',
										width:660,
										height:280,
										layout:'fit',
										buttonAlign:'center',
										items:[form],
										modal:true,
										plain:true,
                                        cls:'msgHistorialSIUGJ',
										listeners:
											{
												show:
												{
													buffer:10,fn:function()
															{
																var cmbRoles=crearComboExt('cmbRoles',arrRoles,0,0,500,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboRol'});
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
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcAjax, 'POST','funcion=20&extension='+arrId[1],true);
                                                                    
                                                                        
                                                                    }
                                                                    else
                                                                    {
                                                                        cmbExtensiones.hide();
                                                                        Ext.getCmp('lblExtension').hide();
                                                                    }
                                                                    
                                                                }
                                                                
                                                                cmbRoles.on('select',rolSeleccionado);
															}
												}
											},
										buttons:
												[
                                                	{
														text:'Cancelar',
                                                        cls:'btnSIUGJCancel',
                                                        width:140,
														handler:function ()
															{
																ventana.close();
															}
													},
												 	{
														text:'Aceptar',
                                                        cls:'btnSIUGJ',
                                                        width:140,
														handler:function ()
															{
                                                            	var cmbRoles=gEx('cmbRoles')
                                                                var cmbExtensiones=gEx('cmbExtensiones');
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
                                                                var cadPermisos='C';
                                                                var agreg=Ext.getCmp ('chkAgregar');
                                                                var modif=Ext.getCmp ('chkModificar');
                                                                var elim=Ext.getCmp ('chkElminar');
                                                                if(agreg.getValue()==true)
                                                                {
                                                                    cadPermisos=cadPermisos+'A';
                                                                }
                                                                if(modif.getValue()==true)
                                                                {
                                                                    cadPermisos=cadPermisos+'M';
                                                                }
                                                                if(elim.getValue()==true)
                                                                {
                                                                    cadPermisos=cadPermisos+'E';
                                                                }

                                                                var codigoRol=arrId[0]+'_'+extension+'|'+cadPermisos;
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
                                                                    
                                                                    option.text=cmbRoles.getRawValue()+txtExtension+' ['+cadPermisos+']';
                                                                    listRoles.options[listRoles.options.length]=option;
                                                                }
                                                                else
                                                                {
                                                                	msgBox('<?php echo $etj["msgRolYaExisteUsr"]?>')
                                                                    return;
                                                                }
                                                                
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
	var arrValor=valor.split('|');
	var combo=gE(idCombo);
    var x;
    var arrOpcion;
    for(x=0;x<combo.options.length;x++)
    {
    	arrOpcion=combo.options[x].value.split('|');
    	if(arrOpcion[0]==arrValor[0])
        	return true;
    }
    return false;

}