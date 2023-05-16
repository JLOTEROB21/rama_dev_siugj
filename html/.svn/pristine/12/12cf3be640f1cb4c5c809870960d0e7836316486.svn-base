<?php

	session_start();

	include("configurarIdiomaJS.php");

	include("conexionBD.php");

	$consulta="SELECT claveUnidad,nombreUnidad FROM _17_tablaDinamica ";

	

	if($con->existeCampo("cmbCategoria","_17_tablaDinamica"))

		$consulta.=" WHERE cmbCategoria=1";

	

	if($con->existeCampo("prioridad","_17_tablaDinamica"))

		$consulta.="  ORDER BY prioridad";

	else

		$consulta.="  ORDER BY nombreUnidad";

	$arrUnidades=$con->obtenerFilasArreglo($consulta);

	

?>



var arrUnidades=<?php echo $arrUnidades?>;



function mostrarVentanaCambiarAdscripcionUGA()

{

	var cmbAdscripcion=crearComboExt('cmbAdscripcion',arrUnidades,120,5,350);

	var form = new Ext.form.FormPanel(	

										{

											baseCls: 'x-plain',

											layout:'absolute',

											defaultType: 'label',

											items: 	[

                                            			{

                                                        	x:10,

                                                            y:10,

                                                            html:'Adscripci&oacute;n:'

                                                        },

                                                        cmbAdscripcion

													]

										}

									);

	

	var ventanaAM = new Ext.Window(

									{

										title: 'Cambiar adscripci&oacute;n usuario',

										width: 600,

										height:130,

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

																		if(cmbAdscripcion.getValue()=='')

                                                                        {

                                                                        	function resp()

                                                                            {

                                                                            	cmbAdscripcion.focus();

                                                                            }

                                                                            msgBox('Debe indicar la adscripci&oacute;n a asignar',resp);

                                                                        	return;

                                                                        }

                                                                        

                                                                        

                                                                        function funcAjax()

                                                                        {

                                                                            var resp=peticion_http.responseText;

                                                                            arrResp=resp.split('|');

                                                                            if(arrResp[0]=='1')

                                                                            {

                                                                            	function respAux()

                                                                                {

                                                                                	location.reload();



                                                                                }

                                                                                msgBox('Se ha cambiado la adscripcion exitosamente',respAux);

                                                                            }

                                                                            else

                                                                            {

                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);

                                                                            }

                                                                        }

                                                                        obtenerDatosWeb('../paginasFunciones/funcionesPortal.php',funcAjax, 'POST','funcion=86&adscripcion='+cmbAdscripcion.getValue(),true);

                                                                        

                                                                        

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



<?php

if(existeRol("'1_0'"))

{

?>

function mostrarVentanaCambiarIdentidad()

{

	 var oConf=	{

                    idCombo:'cmbIdentidad',

                    anchoCombo:350,

                    posX:140,

                    posY:5,

                    raiz:'personas',

                    campoDesplegar:'Nombre',

                    campoID:'idUsuario',

                    funcionBusqueda:1,

                    paginaProcesamiento:'../Usuarios/procesarbUsuario.php',

                    confVista:'<tpl for="."><div class="search-item">({idUsuario}) {Nombre}<br></div></tpl>',

                    campos:	[

                                {name:'idUsuario'},

                                {name:'Nombre'}



                            ],

                    funcAntesCarga:function(dSet,combo)

                                {

                                    idUsuario=-1;

                                    var aValor=combo.getRawValue();

                                    dSet.baseParams.criterio=aValor;

                                    dSet.baseParams.campoBusqueda=5;

                                    

                                },

                    funcElementoSel:function(combo,registro)

                                {

                                    idUsuario=registro.data.idUsuario;

                                    

                                }  

                };

	var cmbUsuario=crearComboExtAutocompletar(oConf);

	var form = new Ext.form.FormPanel(	

										{

											baseCls: 'x-plain',

											layout:'absolute',

											defaultType: 'label',

											items: 	[

                                            			{

                                                        	x:10,

                                                            y:10,

                                                            html:'Identidad a tomar:'

                                                        },

                                                        cmbUsuario

													]

										}

									);

	

	var ventanaAM = new Ext.Window(

									{

										title: 'Cambiar identidad de usuario',

										width: 600,

										height:130,

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

																		if(idUsuario=='-1')

                                                                        {

                                                                        	function resp()

                                                                            {

                                                                            	cmbUsuario.focus();

                                                                            }

                                                                            msgBox('Debe indicar la identidad a tomar',resp);

                                                                        	return;

                                                                        }

                                                                        

                                                                        

                                                                        function funcAjax()

                                                                        {

                                                                            var resp=peticion_http.responseText;

                                                                            arrResp=resp.split('|');

                                                                            if(arrResp[0]=='1')

                                                                            {

                                                                            	function respAux()

                                                                                {

                                                                                	location.reload();



                                                                                }

                                                                                msgBox('La identidad ha sido cambiada exitosamente',respAux);

                                                                            }

                                                                            else

                                                                            {

                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);

                                                                            }

                                                                        }

                                                                        obtenerDatosWeb('../paginasFunciones/funcionesPortal.php',funcAjax, 'POST','funcion=87&idUsuario='+idUsuario,true);

                                                                        

                                                                        

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



function restaurarIdentidad()

{

	function funcAjax()

    {

        var resp=peticion_http.responseText;

        arrResp=resp.split('|');

        if(arrResp[0]=='1')

        {

            function respAux()

            {

                location.reload();



            }

            msgBox('La identidad ha sido restaurada exitosamente',respAux);

        }

        else

        {

            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);

        }

    }

    obtenerDatosWeb('../paginasFunciones/funcionesPortal.php',funcAjax, 'POST','funcion=88',true);	

}



<?php

}

?>