<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$idUsuario=bD($_GET["u"]);
	$vCU=isset($_GET["vCU"])?$_GET["vCU"]:0;
	$arrBtn="";
	
	$consulta="SELECT Nombre,cuentaActiva FROM 800_usuarios WHERE idUsuario=".$idUsuario;
	$fRegistroUsuario=$con->obtenerPrimeraFilaAsoc($consulta);
	
	
	$lblCuentaActiva="";
	switch($fRegistroUsuario["cuentaActiva"])
	{
		case 0:
			$lblCuentaActiva="Cuenta Inactiva";
		break;
		case 1:
			$lblCuentaActiva="Cuenta Activa";
		break;
		case 100:
			$lblCuentaActiva="Cuenta Bloqueda";
		break;
	}
	
	$nombreUsuario=$fRegistroUsuario["Nombre"];
	
	
	$posIni=320;
	if(existeRol("'1_0'"))
		$posIni=390;
	$consulta="SELECT * FROM 800_usuariosVSDatosComplementarios WHERE situacion=1 ORDER BY prioridad,etiquetaModulo";
	if($vCU==1)
	{
		$consulta="SELECT * FROM 800_usuariosVSDatosComplementarios WHERE situacion=1 and mostrarVistaCuentaUsuario=1 ORDER BY prioridad,etiquetaModulo";
	}
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_assoc($res))
	{
		$mostrar=1;
		if(($fila["funcionAplicacion"]!="")&&($fila["funcionAplicacion"]!="-1"))
		{
			$obj=json_decode('{"idUsuario":"'.$idUsuario.'","vCU":"'.$vCU.'"}');
			$cache=NULL;
			$objParametros=$obj;
			$mostrar=removerComillasLimite(resolverExpresionCalculoPHP($fila["funcionAplicacion"],$objParametros,$cache));
			
		}
		
		
		if($mostrar==1)
		{
			$btn="		{
							width:160,
							height:40,
							x:20,
							enableToggle :true,
							toggleGroup :'presionado',
							xtype:'button',
							y:".$posIni.",
							text:'".cv($fila["etiquetaModulo"])."',
							toggleHandler :function(btn,presionado)
									{
										if(presionado)
										{
											cargarModuloUsuario(".$fila["IDModulo"].");
										}
									}
							
						}";
		
			if($arrBtn=="")
				$arrBtn=",".$btn;
			else
				$arrBtn.=",".$btn;
			$posIni+=40;
		}
	}
	
?>

var btnPresionado=null;
Ext.onReady(inicializar);

function inicializar()
{

	var htmlPanel=	'<table width="280" onclick="cancelarEvento()"><tr><td align="center" onclick="javascript:mostrarVentanaCambiarFoto()"><img id="imgUsr" height="297" width="260" '+
                    ' src="../Usuarios/verFoto.php?Id='+gE('idUsuario').value+'&rand=<?php echo date("YmdHis")?>">'+
                    '</td></tr><tr><td align="center"><span class="letraNombreTablero" style="font-size:18px; line-height:22px" id="lblNombreUsuario"><?php echo $nombreUsuario?>'+
                    '<br>(<?php echo $idUsuario?>)</span><BR /><BR /><span class="letraNombreTablero" id="lblStatusCuenta" style="font-size:16px; line-height:20px; color:#1A3E9A !important" >-- <?php echo $lblCuentaActiva ?> ---</span></td></tr>';
   	<?php
	if(existeRol("'1_0'"))
	{
	?>
    	if(gE('vCU').value=='0')
        {
    	 /*htmlPanel+=	'<tr><td align="center"><br /><span class="letraFichaRespuesta">Para eliminar este usuario<br />de click</span>'+
                    ' <a href="javascript:removerUsuario(\'<?php echo base64_encode($idUsuario)?>\')"><span class="letraRoja">'+
                    'AQUÍ <img src="../images/delete.png" /> </span></a></td></tr>';*/
   		
        	htmlPanel+=	'<tr><td align="center"><br /><span id="btnEliminar"></span></a></td></tr>'
        }
   
    <?php
	}
	?>
                    
    htmlPanel+='</table>';

    new Ext.Viewport(	{
                                layout: 'border',
                                border:false,
                                items: [
                                			{
                                                xtype:'panel',
                                                width:300,  
                                                border:false,                                                              
                                                region:'west',
                                                
                                                layout:'absolute',
                                                items:	[
                                                            {
                                                                x:0,
                                                                y:45,
                                                                xtype:'label',
                                                                html:htmlPanel
                                                            }
                                                        ]
                                            },
                                            {
                                                xtype:'tabpanel',
                                                cls:'tabPanelSIUGJ',
                                                border:false,    
                                                activeTab:1, 
                                                id:'tabSecciones', 
                                                listeners	:
                                                				{
                                                                	tabchange:function(tabPanel, tab )
                                                                    			{
                                                                                	if(tab.id=='tabCuenta')
                                                                                    {
                                                                                    	
                                                                                    }
                                                                                }
                                                                },   
                                                region:'center',
                                                items:	[
                                                         	{
                                                            	xtype:'panel',
                                                                border:false,
                                                                title:'Datos de identificaci&oacute;n',
                                                                region:'center',
                                                                layout:'absolute',
                                                                items:	[
                                                                			  new Ext.ux.IFrameComponent({ 

                                                                                                            id: 'frameContenido1', 
                                                                                                            anchor:'100% 100%',
                                                                                                            border:false,
                                                                                                            loadFuncion:function(iFrame)
                                                                                                                        {
                                                                                                                            
                                                                                                                            
                                                                                                                           
                                                                                                                            
                                                                                                                        },
                    
                                                                                                            url: '../paginasFunciones/white.php',
                                                                                                            style: 'width:100%;height:700px' 
                                                                                                    })
                                                                			
                                                                		]
                                                            } ,
                                                            {
                                                            	xtype:'panel',
                                                                border:false,
                                                                title:'Datos de la cuenta',
                                                                region:'center',
                                                                id:'tabCuenta',
                                                                layout:'absolute',
                                                                items:	[
                                                                			 new Ext.ux.IFrameComponent({ 

                                                                                                            id: 'frameContenido2', 
                                                                                                            anchor:'100% 100%',
                                                                                                            border:false,
                                                                                                            loadFuncion:function(iFrame)
                                                                                                                        {
                                                                                                                            
                                                                                                                            
                                                                                                                            
                                                                                                                            
                                                                                                                        },
                    
                                                                                                            url: '../paginasFunciones/white.php',
                                                                                                            style: 'width:100%;height:700px' 
                                                                                                    })
                                                                			
                                                                		]
                                                            }    
                                                        ]
                                            }
                                         ]
                            }
                        )   
                        
	                       
	cargarFrameDatosCuenta();
    
    setTimeout(function()
              {
                  
                   gEx('tabSecciones').setActiveTab(0);
                   cargarFrameDatosIdentificacion(); 
              }, 
              2000);
    
   
    	            

	if(gE('btnEliminar'))
    {
        new Ext.Button (
                                {
                                   
                                    text:'Eliminar usuario',
                                    width:200,
                                    height:40,
                                    icon:'../principalPortal/imagesSIUGJ/trash.png',
                                    cls:'btnSIUGJDelete',
                                    renderTo:'btnEliminar',
                                    handler:function()
                                            {
                                               removerUsuario();
                                            }
                                    
                                }
                            )
	}
}


function cargarFrameDatosIdentificacion()
{

	gEx('frameContenido1').load	(
                                                    {
                                                        url:'../Usuarios/nIdentifica.php',
                                                        params:		{
                                                                        idUsuario:gE('idUsuario').value,
                                                                        bandera:1,
                                                                        vCU:gE('vCU').value,
                                                                        cPagina:'sFrm=true'
                                                                    }
                                                    }
                                                    
                                                )
}

function cargarFrameDatosCuenta()
{
	gEx('frameContenido2').load	(
                                                    {
                                                        url:'../Usuarios/nUsuarios.php',
                                                        params:		{
                                                                        idUsuario:gE('idUsuario').value,
                                                                        bandera:1,
                                                                        vCU:gE('vCU').value,
                                                                        cPagina:'sFrm=true'
                                                                    }
                                                    }
                                                    
                                                )
}


function regresarGuardar(bandera)
{
	switch(bandera)
    {
    	case 'nIdentifica':
        	gE('imgUsr').setAttribute('src','../Usuarios/verFoto.php?Id='+gE('idUsuario').value+'&rand='+(new Date().format('YmdHis')));
            gEx('frameContenido1').load	(
                                                    {
                                                        url:'../Usuarios/nIdentifica.php',
                                                        params:		{
                                                                        idUsuario:gE('idUsuario').value,
                                                                        bandera:1,
                                                                        actualizado:1,
                                                                        vCU:gE('vCU').value,
                                                                        cPagina:'sFrm=true'
                                                                    }
                                                    }
                                                    
                                                )
		break;
        case 'nUsuarios':
        	
            gEx('frameContenido2').load	(
                                                    {
                                                        url:'../Usuarios/nUsuarios.php',
                                                        params:		{
                                                                        idUsuario:gE('idUsuario').value,
                                                                        bandera:1,
                                                                        actualizado:1,
                                                                        vCU:gE('vCU').value,
                                                                        cPagina:'sFrm=true'
                                                                    }
                                                    }
                                                    
                                                )
		break;
    }
}

function cargarModuloUsuario(oConf)
{
	if(oConf.idProceso)
    {
    	var content=Ext.getCmp('frameContenidoUsuario');
        content.load({ scripts:true,url:'../modeloProyectos/visorRegistrosProcesosV2.php',params:{actor:"'"+oConf.rolIngreso+"'",vCU:gE('vCU').value,tipoVista:1,sL:0,pantallaCompleta:1,idProceso:oConf.idProceso,cPagina:'sFrm=true',idReferencia:gE('idUsuario').value,idFormulario:-1}});
    }
}

function recargarContenedorCentral()
{
	if((gEx('frameContenidoUsuario'))&&( gEx('frameContenidoUsuario').getFrameWindow().recargarContenedorCentral))
		gEx('frameContenidoUsuario').getFrameWindow().recargarContenedorCentral();
    else
		recargarPagina();

    
}

function setNombreUsuario(lblNombre)
{
	gE('lblNombreUsuario').innerHTML=lblNombre;
}

function removerUsuario()
{
	function resp(btn)
	{
		if(btn=='yes')
		{
        	
			function funcAjax()
			{
				var resp=peticion_http.responseText;
				arrResp=resp.split('|');
				if(arrResp[0]=='1')
				{
					window.parent.cerrarVentanaFancy();
				}
				else
				{
					msgBox('No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema:'+' <br />'+arrResp[0]);
				}
			}
			obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcAjax, 'POST','funcion=26&usr='+bE(gE('idUsuario').value),true);
		}
	}
	msgConfirm('Est&aacute; seguro de querer eliminar del sistema al usuario seleccionado?<br />(Esta operaci&oacute;n NO podr&aacute; deshacerse)',resp)
}

function mostrarVentanaCambiarFoto()
{
    cancelarEvento();
    
   

	var tabla='<div><input type="text" id="txtFileName" disabled="true" style="border: solid 1px; background-color: #FFFFFF; width: 290px" /></div><div class="flash" id="fsUploadProgress">'+ 
					'</div><input type="hidden" name="hidFileID" id="hidFileID" value="" /> ';       					
					
	
    
    
    var cObj={

                    upload_url: "../modulosEspeciales_SGJP/procesarComprobante.php", //lquevedor
                    file_post_name: "archivoEnvio",
     
                    // Flash file settings
                    file_size_limit : '10 MB',
                    file_types : '*.jpg;*.png;*.bmp;*.gif;*.jpeg',			// or you could use something like: "*.doc;*.wpd;*.pdf",
                    file_types_description : "Archivos de imagen",
                    file_upload_limit : 0,
                    file_queue_limit : 1,     
                   
                    upload_success_handler : subidaCorrecta,
                    
                    
                }
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														  {
                                                              xtype:'label',
                                                              x:10,
                                                              y:20,
                                                              cls:'SIUGJ_Etiqueta',
                                                              html:'Archivo de imagen:'
                                                          },
                                                          {
                                                            x:230,
                                                            y:15,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:	'<table width="340"><tr><td><div id="uploader"><p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p></div></td></tr><tr id="filaAvance" style="display:none"><td align="right"><span style="font-size:11px" class="SIUGJ_Etiqueta">Porcentaje de avance:</span> <span style="font-size:11px" id="porcentajeAvance" class="SIUGJ_Etiqueta"> 0%</span></td></tr></table>'
                                                        },
                                                       
                                                        {
                                                            x:590,
                                                            y:13,
                                                            id:'btnUploadFile',
                                                            width:120,
                                                            icon:'../images/add.png',
                                                            
                                                            xtype:'button',
                                                            cls:'btnSIUGJCancel',
                                                            text:'Seleccionar',
                                                            handler:function()
                                                                    {
                                                                        $('#containerUploader').click();
                                                                    }
                                                        },
							 							{
                                                            x:185,
                                                            y:10,
                                                            hidden:true,
                                                            html:	'<div id="containerUploader"></div>'
                                                        },
                                                        
                                                        {
                                                            x:290,
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
									);
	
    
    
	var ventanaAM = new Ext.Window(
									{
										title: 'Adjuntar archivo de imagen',
										width: 800,
                                        cls:'msgHistorialSIUGJ',
                                        id:'vFotoUsuario',
										height:190,
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
                                                                       crearControlUploadHTML5(cObj);
                                                                	
                                                                        
                                                                
																}
															}
												},
										buttons:	[
                                        				{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            width:140,
															cls:'btnSIUGJCancel',
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            width:140,
															cls:'btnSIUGJ',
															handler: function()
																	{
                                                                    	
                                                                    	
																		
                                                                       
                                                                        if(uploadControl.files.length==0)
                                                                        {
                                                                            msgBox('Debe ingresar el documento que desea adjuntar');
                                                                            return;
                                                                        }
                                                                        uploadControl.start();
                                                                       
																	}
														}
														
													]
									}
								);
	ventanaAM.show();
    
}


function subidaCorrecta(file, serverData) 
{


    file.id = "singlefile";	// This makes it so FileProgress only makes a single UI element, instead of one for each file
    var arrDatos=serverData.split('|');

    if ( arrDatos[0]!='1') 
    {

    } 
    else 
    {
        
        gEx("idArchivo").setValue(arrDatos[1]);
        gEx("nombreArchivo").setValue(arrDatos[2]);
       	if(gE('txtFileName'))
	        gE('txtFileName').value=arrDatos[2];
        
        

        
        var cadObj='{"idUsuario":"'+gE('idUsuario').value+'","idArchivo":"'+arrDatos[1]+'","nombreArchivo":"'+arrDatos[2]+'"}';
    
        function funcAjax2(peticion_http)
        {
            var resp=peticion_http.responseText;
            
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
            	
                gE('imgUsr').src='../Usuarios/verFoto.php?Id='+gE('idUsuario').value+'&rand='+generarNumeroAleatorio(1000,99999);
                gEx('vFotoUsuario').close();
                
            }
            else
            {
                
	             msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWebV2('../paginasFunciones/funcionesUsuarios.php',funcAjax2, 'POST','funcion=105&cadObj='+cadObj,true);
        
        
        
    }
		
	
}