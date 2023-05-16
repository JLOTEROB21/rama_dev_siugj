<?php session_start();
include("configurarIdiomaJS.php");
$superUsr="false";
if(existeRol("'1_0'"))
	$superUsr="true";
$idUsuario="-1";
if(isset($_SESSION["idUsr"])&&($_SESSION["idUsr"]!=""))
	$idUsuario=$_SESSION["idUsr"];
	
	
$consulta="SELECT codigoUnidad,unidad FROM 817_organigrama ORDER BY unidad"	;
$arrLugares=uEJ($con->obtenerFilasArreglo($consulta));
$paramComp="";
?>
var sr=<?php echo $superUsr?>;
var usr='<?php echo bE($idUsuario)?>';

Ext.onReady(inicializar);

function inicializar()
{
	
	$('.tabs_hayas').jqsimplemenu();
    $('.menu2').jqsimplemenu();
    $("ul.sf-menu").superfish().find('ul').bgIframe({opacity:false}); 

	var url='../agenda/agenda.php';
    <?php
    if(existeRol("'51_0'"))
    {
        echo "url='../proveedores/agendaProveedor.php';";
    }
	?>
	/*var dtePicker=new Ext.DatePicker(
                                            {
                                            	renderTo:'spCalendario',
                                                id:'dteCalendario'
                                            }
                                          )
	dtePicker.on('select',	function(dte,fecha)
    						{
                            	var arrDatos=[['fechaInicial',fecha.format('Y-m-d')]];
                                window.open('',"vAuxiliar", "toolbar=no,directories=no,menubar=no,status=no,scrollbars=yes,fullscreen=yes");
                                enviarFormularioDatos(url,arrDatos,'POST','vAuxiliar');
                            }
    
    			)*/   
	try
    {
		var urlInicio='../reportes/principalInicio.php';
    	//var urlInicio='';
    	//var urlInicio='../agenda/calendario.php';
    	//urlInicio='../calendario/muestraCal.php';
        //urlInicio='../agenda/agenda.php';
        <?php
			if(strpos($urlSitio,"censida.grupolatis.net")!==false)
			{
				if(existeRol("'15_0'"))
				{
					//echo "var urlInicio='../reportes/validacionProduccionCientifica.php';";
				}
				if(existeRol("'51_0'"))
				{
					echo "urlInicio='../adquisiciones/listadoConvocatoriasDisp.php';";
				}
				if(existeRol("'37_0'"))
				{
					echo "urlInicio='../modulosEspeciales_Censida/proyectos2012.php';";
				}
				if(existeRol("'10_0'"))
				{
					echo "urlInicio='../modulosEspeciales_Censida/proyectosRevisor2012.php';";
				}
				
				if(existeRol("'62_0'"))
				{
					echo "urlInicio='../modulosEspeciales_Censida/registroDatosOSC.php';";
				}
				
				$consulta="SELECT DISTINCT idComite FROM 2007_rolesVSComites WHERE rol IN (".$_SESSION["idRol"].")";
				$con->obtenerFilas($consulta);
				if($con->filasAfectadas>0)
				{
					echo "urlInicio='../modulosEspeciales_Censida/vistaComites.php';";
				}
				if(existeRol("'70_0'"))
				{
					echo "urlInicio='../modulosEspeciales_Censida/tblMarcoProyectos.php';";
				}
			}
		?>
		
		<?php
			if(isset($_SESSION["idUsr"])&&($_SESSION["idUsr"]!="-1"))
			{
				$nUsuarioActual=obtenerNombreUsuario($_SESSION["idUsr"]);
				$mostrarMenu=false;
				if(existeRol("'6_0'"))
				{
					$consulta="SELECT a.idAlumno,u.Nombre FROM 4125_alumPers a,800_usuarios u WHERE u.idUsuario=a.idAlumno and a.idUsuario=".$_SESSION["idUsr"]." order by nombre"	;
					$resAlumos=$con->obtenerFilas($consulta);
					if($con->filasAfectadas>0)
					{
						$mostrarMenu=true;
						$arrAgendas="";
						while($fAlumno=mysql_fetch_row($resAlumos))
						{
							$obj="	,{
										xtype:'menuitem',
										text:'".$fAlumno[1]."',
										handler:function()
											{
												gEx('frameContenido').load	(
																				{
																					url:urlInicio,
																					scripts:true,
																					params:	{
																								cPagina:'sFrm=true',
																								sL:'1',
																								idUsuario:".$fAlumno[0]."
																							}
																				}
																			)
												gEx('panelAgenda').setTitle('Agenda [".$fAlumno[1]."]');                                    
											}
									}";	
							if($arrAgendas=="")		
								$arrAgendas=$obj;
							else
								$arrAgendas.=$obj;
						}
					}
				}

				if(existeRol("'7_0'"))
				{
					if(strpos($urlSitio,"ugm.grupolatis.net")!==false)
					{
						$consulta="	SELECT idRegistro,p.ciclo,t.codigoInstitucion FROM 9118_convocatoriasPublicadas p,_443_tablaDinamica t WHERE idFormulario=443 AND t.id__443_tablaDinamica=p.idRegistro
									AND fechaIniPublica<='".date("Y-m-d")."' AND fechaFinPublica>='".date("Y-m-d")."' AND STATUS=1";
									
						$res=$con->obtenerFilas($consulta);
						
						$arrPlantel=array();
						while($fila=mysql_fetch_row($res))
						{
							$arrPlantel[$fila[1]."_".$fila[2]]="";
						}
						$cadPlantel="";
						if(sizeof($arrPlantel)>0)
						{
							foreach($arrPlantel as $p=>$r)
							{
								if($cadPlantel=="")
									$cadPlantel=$p;
								else
									$cadPlantel.=",".$p;
							}
							
							echo "urlInicio='../planteles/evaluacionDocente.php';";
							$paramComp=",cadPlantel:'".$cadPlantel."'";
							
						}
					}
				}
		?>

                if(urlInicio!='')
                {
                    var contenido=new Ext.Panel	(
                                                    	{	
                                                        	width:850,
                                                            height:820,
                                                            border:false,
                                                            activeTab: 0,
                                                           	renderTo:'tblIFrame',
                                                            items:	[
                                                            			{
                                                                                        
                                                                            id:'frameContenido',
                                                                            xtype:'iframepanel',
                                                                            height:850,
                                                                            border:false,
                                                                            autoLoad:	{	
                                                                                            url:urlInicio,
                                                                                            scripts:true,
                                                                                            params:	{
                                                                                                        cPagina:'sFrm=true',
                                                                                                        sL:'1'<?php echo $paramComp?>
                                                                                                    }
                                                                                        },
                                                                             loadMask:	{
                                                                                            msg:'Cargando'
                                                                                        }
                                                                        }
                                                                         
                                                                    ]		
                                                        }
                                                )
				}                                        
        <?php
			}
		?>
		
    }
    catch(e)
    {
    	alert(e);
    }
}

function ejecutarFuncionIframe(funcion,params)
{
	var frameContenido=gEx('frameContenido');
    var pagina=frameContenido.getFrameWindow();
    eval('pagina.'+funcion+'('+bD(params)+');');
}

function ejecutarAccion(id)
{
		gE('programa').value=id;
		gE('enviaProgram').submit();

}

var map = new Ext.KeyMap(document, 
								{
									key: 13, 
									fn: autentificarUsuario,
									scope: this
								}
							);

RegistroSimple =Ext.data.Record.create	(
											[
												{name:'id'},
												{name:'nombre'}
											]
										)



function mostrarVSelIdioma()
{
	var tablaDatosIdiomas=[];
	var tablaDatosPaginas=[['-1','<?php echo $etj["lblTodos"]?>']];
	var dsIdiomas= new Ext.data.SimpleStore	(
											 	{
													fields:	[
															 	{name:'id'},
																{name:'nombre'}
																
															]
												}
											)

	var dsPaginas= new Ext.data.SimpleStore	(
											 	{
													fields:	[
															 	{name:'id'},
																{name:'nombre'}
																
															]
												}
											)

	dsIdiomas.loadData(tablaDatosIdiomas);	
	dsPaginas.loadData(tablaDatosPaginas)
	cargarDatosIdioma(dsIdiomas);
	
	
	
	var comboIdioma=document.createElement('select');
	var comboPaginas=document.createElement('select');
	
	
	var comboIdiomas=new Ext.form.ComboBox	(
												{
													x:105,
													y:5,
													id:'IDcomboIdioma',
													mode:'local',
													emptyText:'<?php echo $etj["lblElijaOpcion"] ?>',
													store:dsIdiomas,
													displayField:'nombre',
													valueField:'id',
													transform:comboIdiomas,
													editable:false,
													typeAhead: true,
													triggerAction: 'all',
													lazyRender:true
												
												}
											)
	

	var comboPaginas=new Ext.form.ComboBox	(
												{
													x:105,
													y:35,
													id:'IDcomboPagina',
													mode:'local',
													emptyText:'<?php echo $etj["lblTodos"]?>',
													store:dsPaginas,
													displayField:'nombre',
													valueField:'id',
													transform:comboPaginas,
													editable:false,
													typeAhead: true,
													triggerAction: 'all',
													lazyRender:true
													
												}
											)


	var form = new Ext.form.FormPanel(	
										 	{
												baseCls: 'x-plain',
												layout:'absolute',
												defaultType: 'textfield',
												items: 	[
														 	new Ext.form.Label	(
																				 	{
																						x:5,
																						y:10,
																						text:'<?php echo $etj["selIdioma"]?>'
																					}
																				)
															,
															comboIdiomas,
															new Ext.form.Label	(
																				 	{
																						x:5,
																						y:40,
																						text:'<?php echo $etj["selPagina"]?>'
																					}
																				)
															,
															comboPaginas
															
															
														]
											}
										);
	
	
	ventanaIdioma = new Ext.Window	(
									{
										title: '<?php echo $etj["lblAplicacion"] ?>',
										width: 300,
										height:150,
										minWidth: 280,
										minHeight: 100,
										layout: 'fit',
										plain:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										modal:true,
										buttons:	[
														{
															text: '<?php echo $etj["lblBtnAceptar"] ?>',
															handler:function()
																	{
																		if(comboIdiomas.getValue()!="")
																		{
																			gE('idioma').value=comboIdiomas.getValue();
																			gE('pagina').value=comboPaginas.getValue();
																			gE('frmEnvio').action="cfgIdiomaSistema.php";
																			gE('frmEnvio').submit();
																			ventanaIdioma.close();
																		}
																		else
																		{
																			msgBox('<?php echo $etj["lblDebeElegir"] ?>');
																			comboIdiomas.focus(true);
																		}
																	}
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
															handler:function()
																	{
																		ventanaIdioma.close();
																	}
														}
													]
    								}
								);

    ventanaIdioma.show();
		//comboIdiomas.select(1);

	function cargarDatosIdioma(dsDestino)
	{
		obtenerDatosWeb("../paginasFunciones/funcionesRevistaE.php",insertarDatosIdioma,'POST','funcion=11',true);
		function insertarDatosIdioma()
		{
			var resp=peticion_http.responseText;
			var listIdioma=eval(resp);
			
			for(x=0;x<listIdioma.length;x++)
			{
				var r=new RegistroSimple	(
												{
													id:listIdioma[x].id,
													nombre:listIdioma[x].idioma
												}
											);
				dsDestino.add(r);
					
			}
			cargarDatosPagina(dsPaginas);

				
			
		}
	}
	
	function cargarDatosPagina(dsDestino)
	{
		obtenerDatosWeb("../paginasFunciones/funcionesRevistaE.php",insertarDatosPagina,'POST','funcion=12',true);
		function insertarDatosPagina()
		{
			var resp=peticion_http.responseText;
			var listPaginas=eval(resp);
			
			for(x=0;x<listPaginas.length;x++)
			{
				var r=new RegistroSimple	(
												{
													id:listPaginas[x],
													nombre:listPaginas[x]
												}
											);
				dsDestino.add(r);
					
			}

		}
	}
	
}

function autentificarUsuario()
{
	var login=gE('txtLogin').value;
	var passwd=gE('txtPass').value;
	var param=	'{'+
					'"L":"'+login+'",'+
					'"P":"'+passwd+'"'+
				'}';
	
	obtenerDatosWeb('../paginasFunciones/funciones.php',procResp,'POST','funcion=1&param='+param,true);
	function procResp()
	{
		var resp=peticion_http.responseText;
        if(resp==-100)
        {
             Ext.MessageBox.alert(lblAplicacion,'No puede accesar al sistema, ya que no cuenta con datos de adscripci&oacute;n');
        }
        else
        {
			var objResp=eval(resp);
            if(objResp!=false)
            {
                location.href="../principal/inicio.php";
            }
            else
            {
                  mE('filaErrorLogin');
                  gE('txtLogin').focus();
            }        
        }
	}			
}


function mostrarVentaNuevoEvento()
{
	var cmbSede=crearComboExt('cmbSede',<?php echo $arrLugares?>,85,10,300);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	html:'Lugar:',
                                                            x:10,
                                                            y:15
                                                        },
                                                        cmbSede,
                                                        {
                                                        	html:'Fecha inicial:',
                                                            x:10,
                                                            y:45
                                                            
                                                        },
                                                        {
                                                        	xtype:'datefield',
                                                            id:'dteFechaIni',
                                                            x:85,
                                                            y:40,
                                                            minValue:'<?php echo date('d/m/Y')?>'
                                                        	
                                                        },
                                                        /*{
                                                        	html:'Fecha final:',
                                                            x:200,
                                                            y:45
                                                        },
                                                        {
                                                        	xtype:'datefield',
                                                            id:'dteFechaFin',
                                                            x:275,
                                                            y:40,
                                                            minValue:'<?php echo date('d/m/Y')?>'
                                                        },*/
                                                        {
                                                        	html:'Hora inicio:',
                                                            x:10,
                                                            y:75
                                                        },
                                                        {
                                                        	id:'dteHoraInicio',
                                                        	xtype:'timefield',
                                                            x:85,
                                                            y:70,
                                                            width:105,
                                                            minValue:'07:00 AM',
                                                            maxValue:'11:45 PM'
                                                        },
                                                        
                                                        {
                                                        	html:'Hora final:',
                                                            x:200,
                                                            y:75
                                                        },
                                                        {
                                                        	id:'dteHoraFin',
                                                        	xtype:'timefield',
                                                            x:275,
                                                            y:70,
                                                            width:105,
                                                             minValue:'07:00 AM',
                                                             maxValue:'11:45 PM'
                                                        },
                                                        {
                                                        	html:'Descripci&oacute;n:',
                                                            x:10,
                                                            y:105
                                                        },
                                                        {
                                                        	id:'txtComentario',
                                                        	xtype:'textarea',
                                                            x:85,
                                                            y:100,
                                                            width:300,
                                                            height:75
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agendar evento',
										width: 500,
										height:270,
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
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		if(cmbSede.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbSede.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el lugar donde se llevar&aacute; a cabo el evento',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        var dteFechaIni=gEx('dteFechaIni');
                                                                        //var dteFechaFin=gEx('dteFechaFin');
                                                                        var dteHoraInicio=gEx('dteHoraInicio');
                                                                        var dteHoraFin=gEx('dteHoraFin');
                                                                        var txtComentario=gEx('txtComentario');
                                                                        if(cmbSede.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbSede.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el lugar donde se llevar&aacute; a cabo el evento',resp2);
                                                                            return;
                                                                        }
                                                                        if(dteFechaIni.getValue()=='')
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	dteFechaIni.focus();
                                                                            }
                                                                        	msgBox('Debe indicar indicar la fecha de inicio en la cual se llevar&aacute; a cabo el evento',resp3);
                                                                            return;
                                                                        }
                                                                        
                                                                        /* if(dteFechaFin.getValue()=='')
                                                                        {
                                                                        	function resp4()
                                                                            {
                                                                            	dteFechaFin.focus();
                                                                            }
                                                                        	msgBox('Debe indicar indicar la fecha final en la cual se llevar&aacute; a cabo el evento',resp4);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(dteFechaIni.getValue()>dteFechaFin.getValue())
                                                                        {
                                                                        	function resp5()
                                                                            {
                                                                            	dteFechaIni.focus();
                                                                            }
                                                                        	msgBox('La fecha de inicio del evento no puede ser mayor que la fecha de t&eacute;rmino',resp5);
                                                                            return;del
                                                                        }*/
                                                                        
                                                                        if(dteHoraInicio.getValue()=='')
                                                                        {
                                                                        	function resp6()
                                                                            {
                                                                            	dteHoraInicio.focus();
                                                                            }
                                                                        	msgBox('Debe indicar indicar la hora de inicio del evento',resp6);
                                                                            return;
                                                                        }
                                                                        
                                                                         if(dteHoraFin.getValue()=='')
                                                                        {
                                                                        	function resp7()
                                                                            {
                                                                            	dteHoraFin.focus();
                                                                            }
                                                                        	msgBox('Debe indicar indicar la hora de t&eacute;rmino del evento',resp7);
                                                                            return;
                                                                        }
                                                                        var hIinicio=new Date('01/01/2011 '+dteHoraInicio.getValue());
                                                                        var hFin=new Date('01/01/2011 '+dteHoraFin.getValue());
                                                                        if(hIinicio>hFin)
                                                                        {
                                                                        	function resp8()
                                                                            {
                                                                            	dteHoraInicio.focus();
                                                                            }
                                                                        	msgBox('La hora de inicio del evento no puede ser mayor que la hora de t&eacute;rmino',resp8);
                                                                            return;
                                                                        }
                                                                        
                                                                        var cadObj='{"idEvento":"-1","lugar":"'+cmbSede.getValue()+'","fechaIni":"'+dteFechaIni.getValue().format('Y-m-d')+
                                                                        			'","horaIni":"'+hIinicio.format("H:i")+'","horaFin":"'+hFin.format("H:i")+
                                                                                    '","comentarios":"'+cv(gEx('txtComentario').getValue())+'"}';
                                                                                    
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	gEx('frameContenido').getFrameWindow().recargarPagina();
                                                                            	/*gEx('frameContenido').load	(
                                                                                								{
                                                                                                                	url:'../calendario/muestraCal.php',
                                                                                                                    scripts:true,
                                                                                                                    params:	{
                                                                                                                                cPagina:'sFrm=true'
                                                                                                                            }
                                                                                                                }
                                                                                                            );*/
																				ventanaAM.close();                                                                                                            
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesAgenda.php',funcAjax, 'POST','funcion=1&cadObj='+cadObj,true);
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

function removerEvento(iE)
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
                    gEx('frameContenido').getFrameWindow().recargarPagina();
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesAgenda.php',funcAjax, 'POST','funcion=2&idEvento='+iE,true);
		}
	}
    msgConfirm('Est&aacute; seguro de querer remover el evento seleccionado?',resp);            
}

function registroConvocatoria(c)
{
	var arrParam=[['ciclo',bD(c)]];
    enviarFormularioDatos('../Usuarios/reinscripcion.php',arrParam);
}

function verConvocatoria(iRep,iReg,iPR)
{
	var arrParam=[['idReporte',iRep],['idRegistro',iReg],['iPR',iPR]];
	enviarFormularioDatos('../convocatorias/convocatorias.php',arrParam);
    
    
	/*if(bD(iPR)!='-1')
    {
    	gEx('OpcionesGral').setHeight(380);
        gEx('tblProcesoRegistro').show();
        gEx('tblProcesoRegistro').expand();
        gEx('tblProcesoRegistro').load	(
        									{
                                            	url:'../portal/muestraLinkInscripcion.php',
                                                params:{
                                                			idProceso:iPR
                                                		}
                                            }
        								)
   	}
    else
    {
    	gEx('OpcionesGral').expand();
        gEx('tblProcesoRegistro').hide();
    } */               
}

function ingresarSistema()
{
	var obj={};
    obj.url='../principal/login.php';
    obj.ancho=840;
    obj.alto=420;
    abrirVentanaFancy(obj);
}

function regresar1Pagina()
{
	recargarPagina();
}

function regresar2Pagina()
{
	recargarPagina();
}

function recargarContenedorCentral()
{
	recargarPagina();
    
}

function regresar1PaginaContenedor()
{
	recargarPagina();
}

function regresarPagina2Contenedor()
{
	recargarPagina();
}

function regresarContenedorCentral()
{
	recargarPagina();
}

function funcionAntesCerrar()
{
	recargarPagina();
}