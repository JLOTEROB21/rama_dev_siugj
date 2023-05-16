<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$consulta="select concat(idRol,'_',extensionRol),nombreGrupo from 8001_roles where  idIdioma=".$_SESSION["leng"]." order by nombreGrupo";
	$arrRoles=uEJ($con->obtenerFilasArreglo($consulta));
?>

var regRol;
    
Ext.onReady(inicializar);

function inicializar()
{
	regRol=crearRegistro	(
    							[ 
                                	{name: 'idRol'},
                                    {name: 'Rol'}
                                ]
    						)
	crearGridCategorias();
}

function crearGridCategorias()
{
	
	var dsDatos=eval(bD(gE('arrRoles').value));
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idRol'},
                                                                    {name: 'rol'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Rol',
															width:250,
															sortable:true,
															dataIndex:'rol'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:true,
                                                            id:'gridRoles',

                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            columnLines : true,
                                                            renderTo:'tblRoles',
                                                            height:220,
                                                            width:450,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar Rol',
                                                                            handler:function()
                                                                            		{
                                                                                    	agregarRol();
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Eliminar Rol',
                                                                            handler:function()
                                                                            		{
                                                                                    	var filas=tblGrid.getSelectionModel().getSelections();
                                                                                        if(filas.length==0)	
                                                                                        {
                                                                                        	msgBox('Debe seleccionar los roles que desea remover');
                                                                                            return;
                                                                                        }
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	tblGrid.getStore().remove(filas);
                                                                                            }
                                                                                           
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover los roles seleccionados?',resp);
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;
}

function agregarRol()
{

	
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
                                                                
                                                                var codigoRol=arrId[0]+'_'+extension;
                                                                var rolExiste=existeRol(codigoRol);
                                                                
                                                                if(!rolExiste)
                                                                {
                                                                
                                                                	
                                                                    var nExtension=cmbExtensiones.getValue();
                                                                    var txtExtension='';
                                                                    if(nExtension!='')
                                                                    {
                                                                    	txtExtension=' ('+cmbExtensiones.getRawValue()+')';
                                                                    }
                                                                    
                                                                	var r=new regRol	(		
                                                                    						{
                                                                                            	idRol:codigoRol,
                                                                                                rol: cmbRoles.getRawValue()+txtExtension
                                                                                            }
                                                                    					)
                                                                	gEx('gridRoles').getStore().add(r);
                                                                }
                                                                else
                                                                {
                                                                	msgBox('El rol seleccionado ya ha sido agregado previamente')
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

function existeRol(valor)
{
	var pos=obtenerPosFila(gEx('gridRoles').getStore(),'idRol',valor);
    if(pos==-1)
    	return false;
    return true;
}


function validarFrm()
{
	
	if(validarFormularios('frmEnvio'))
    {
    	var x;
    	var id=gE('id').value;
        var gridRoles=gEx('gridRoles');
        var fila;
        var cadAuxiliar='';
        var obj='';
        for(x=0;x<gridRoles.getStore().getCount();x++)
        {
        	fila=gridRoles.getStore().getAt(x);
            obj='{"idRol":"'+fila.get('idRol')+'"}';
            if(cadAuxiliar=='')
            	cadAuxiliar=obj;
            else
            	cadAuxiliar+=','+obj;
        }
        var objArr='{"arrElementos":['+cadAuxiliar+']}';
        if(id=='-1')
        {
        	gE('funcPHPEjecutarNuevo').value=bE('asociarRolesConexion(@idRegPadre,\''+bE(objArr)+'\')');
        }
        else
        {
        	gE('funcPHPEjecutarModif').value=bE('asociarRolesConexion('+id+',\''+bE(objArr)+'\')');
        }
    	
    	gE('frmEnvio').submit();
    }
}

function verificarConectividad()
{
	var _idTipoConectorint=gE('_idTipoConectorint');
    var t=_idTipoConectorint.options[_idTipoConectorint.selectedIndex].value;
    
	var objDatos='{"t":"'+t+'","u":"'+gE('_Usuariovch').value+'","pw":"'+gE('_passwdvch').value+'","b":"'+gE('_baseDatosvch').value+'","p":"'+gE('_puertoint').value+'","h":"'+gE('_hostvch').value+'"}';
    var obj=bE(objDatos);
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            if(arrResp[1]=='1')
            {
            	msgBox("La conexi&oacute;n se ha llevado a cabo exitosamente");
            }
            else
            {
            	msgBox("No se ha podido llevar a cabo la conexi&oacute;n, verifique los par&aacute;metros registrados");
            }
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesEspecialesSistema.php',funcAjax, 'POST','funcion=1&cadObj='+obj,true);
}