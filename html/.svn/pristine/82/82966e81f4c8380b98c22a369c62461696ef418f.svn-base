<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$arrTipoConectores="";

	$consulta="SELECT idTipoConector,nombreConector,nombreClase FROM 20000_conectoresServiciosNube ORDER BY nombreConector";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_assoc($res))
	{
		$consulta=" SELECT s.idServicioNube,s.nombreServicioNube FROM 20000_serviciosPermiteConector sC,20002_catalogoServiciosNube s 
				WHERE sC.idTipoConector=".$fila["idTipoConector"]." AND sC.tipoServicio=s.idServicioNube
				and s.aplicableUsuario=1 order by nombreServicioNube";
		$arrServiciosNube=$con->obtenerFilasArreglo($consulta);
		
		$o="['".$fila["idTipoConector"]."','".cv($fila["nombreConector"])."',".$arrServiciosNube.",'".cv($fila["nombreClase"])."']";
		if($arrTipoConectores=="")
			$arrTipoConectores=$o;
		else
			$arrTipoConectores.=",".$o;
	}
	
	$arrTipoConectores="[".$arrTipoConectores."]";
?>

Ext.onReady(inicializar);

function inicializar()
{
	window.addEventListener('storage', almcenamientoModificado, false);

}

var cadConexionGlobal=null;
var arrTipoConectores=<?php echo $arrTipoConectores?>;
function mostrarVentanaCrearConexion()
{
	
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:20,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Correo electr&oacute;nico:'
                                                        },
                                                        {
                                                        	x:240,
                                                            y:15,
                                                            xtype:'textfield',
                                                            width:350,
                                                            cls:'controlSIUGJ',
                                                            id:'txtNombreConexion'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Tipo de Conexi&oacute;n:'
                                                        },
                                                        {
                                                        	x:240,
                                                            y:65,
                                                            html:'<div id="divComboTipoConexion"></div>'
                                                        },
                                                         
                                                        {
                                                        	x:10,
                                                            y:120,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Descripci&oacute;n de la Conexi&oacute;n:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:115,
                                                            xtype:'textarea',
                                                            width:600,
                                                            height:60,
                                                            cls:'controlSIUGJ',
                                                            id:'txtDescripcionConexion'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:200,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Servicios a Utilizar:'
                                                        },
                                                        crearGridServicios()
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Configuraci&oacute;n de Conexi&oacute;n',
										width: 690,
										height:490,
										layout: 'fit',
										plain:true,
										modal:true,
                                        cls:'msgHistorialSIUGJ',
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	gEx('txtNombreConexion').focus(false,500);
                                                                    
                                                                    var cmbTipoConexion=crearComboExt('cmbTipoConexion',arrTipoConectores,0,0,320,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboTipoConexion'});
                                                                    cmbTipoConexion.on('select',function(cmb,registro)
                                                                                                {
                                                                                                    gEx('gServicios').getStore().removeAll();
                                                                                                    gEx('gServicios').getStore().loadData(registro.data.valorComp);
                                                                                                }
                                                                                    )
                                                                    
                                                                    
                                                                    
																}
															}
												},
										buttons:	[
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
                                                        {
															
															text: 'Siguiente >>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler: function()
																	{
																		var txtNombreConexion=gEx('txtNombreConexion');
                                                                        var txtDescripcionConexion=gEx('txtDescripcionConexion');
																		var cmbTipoConexion=gEx('cmbTipoConexion');
                                                                    	if(txtNombreConexion.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtNombreConexion.focus();
                                                                            }
                                                                            msgBox('Debe indicar la direcci&oacute;n de correo electr&oacute;nico asociada a la conexi&oacute;n',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(!validarCorreo(txtNombreConexion.getValue()))
                                                                        {
                                                                        	function resp20()
                                                                            {
                                                                            	txtNombreConexion.focus();
                                                                            }
                                                                            msgBox('La direcci&oacute;n de correo electr&oacute;nico ingresada NO es v&aacute;lida',resp20);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(cmbTipoConexion.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbTipoConexion.focus();
                                                                            }
                                                                            msgBox('Debe indicar el tipo de conexi&oacute;n',resp2);
                                                                            return;
                                                                        }
                                                                        
                                                                        var gServicios=gEx('gServicios');
                                                                        var listaServicios='';
                                                                        var x;
                                                                        var filas=gServicios.getSelectionModel().getSelections();
                                                                        var f;
                                                                        for (x=0;x<filas.length;x++)
                                                                        {
                                                                        	f=filas[x];
                                                                            if(listaServicios=='')
                                                                            	listaServicios=f.data.idServicio;
                                                                            else
                                                                            	listaServicios+=','+f.data.idServicio;
                                                                        }
                                                                        
                                                                        if(listaServicios=='')
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	txtNombreConexion.focus();
                                                                            }
                                                                            msgBox('Debe indicar lo servicios a utilizar a trav&eacute;s de esta conexi&oacute;n',resp3);
                                                                            return;
                                                                        }
                                                                        
                                                                        
                                                                        var cadObj='{"nombreConexion":"'+cv(txtNombreConexion.getValue())+'","tipoConexion":"'+cmbTipoConexion.getValue()+
                                                                        			'","descripcion":"'+cv(txtDescripcionConexion.getValue())+'","servicios":"'+listaServicios+'"}';
                                                                    	cadConexionGlobal=cadObj;
                                                                        
                                                                        
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                var pos=existeValorMatriz(arrTipoConectores,cmbTipoConexion.getValue());
                                                                                var nombreClase=arrTipoConectores[pos][3];
                                                                                
                                                                                eval(nombreClase+'.continueConfiguration(cadConexionGlobal);');
                                                                                localStorage.removeItem("cuentaNube");
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesEspecialesSistema.php',funcAjax, 'POST','funcion=5&cadObj='+cadObj,true);
                                                                        
                                                                        
                                                                        
                                                                        
                                                                    }
														}
													]
									}
								);
	ventanaAM.show();	

}

function crearGridServicios()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idServicio'},
                                                                    {name: 'descripcionServicio'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({width:40});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer({width:40}),
														chkRow,
														{
															header:'Servicio',
															width:500,
															sortable:true,
															dataIndex:'descripcionServicio'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:false,
                                                            y:195,
                                                            x:10,
                                                            width:600,
                                                            cls:'gridSiugjPrincipal',
                                                            height:150,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            id:'gServicios',
                                                            columnLines : true,
                                                            sm:chkRow
                                                            
                                                        }
                                                    );
	return 	tblGrid;	
}

function almcenamientoModificado()
{
	gEx('grid_tblTabla').getStore().reload();
}