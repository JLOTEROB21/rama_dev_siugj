<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$iRef=$_GET["iRef"];
	
	$consulta="SELECT e.idTabuladorObjetoGasto FROM _547_tablaDinamica c,_539_tablaDinamica i,3206_estructurasProgramaticas e 
			WHERE id__547_tablaDinamica=".$iRef." AND i.id__539_tablaDinamica=c.idReferencia AND e.idRegistro=i.estructuraProgramatica";
	$iClasificador=$con->obtenerValor($consulta);			
	
	$consulta="SELECT idRegistro,CONCAT(noCapitulo,'.- ',nombreCapitulo) FROM 
			3501_clasificadoresObjetosGastoCapitulos WHERE idClasificadorObjetoGasto=".$iClasificador." ORDER BY noCapitulo";
	$arrCapitulos=$con->obtenerFilasArreglo($consulta);
	
	
			
?>
var lblCapitulo='';
var iClasificador=<?php echo $iClasificador?>;
var arrCapitulos=<?php echo $arrCapitulos ?>;
var cadenaFuncionValidacion='funcionPrepararGuardado';

function inyeccionCodigo()
{
	loadScript('../Scripts/funcionesAjaxV2.js',function(){});
	var grid_8450=gEx('grid_8450');
    var btnAdd=gEx('btnAdd_grid_8450');
    
    if(esRegistroFormulario())
    {
        
    	  btnAdd.setHandler(
          						function()
                                {
                                	mostrarVentanaAgregarConcepto();
                                }	
    						)
    
    }
    
    grid_8450.getColumnModel().setRenderer(0,function(val,meta,registro)
                                            {
                                                return mostrarValorDescripcion(formatearValorRenderer(arrCapitulos,val));
                                            }
    								);
    
    grid_8450.getColumnModel().setRenderer(1,function(val,meta,registro)
                                            {
                                                return val;
                                            }
    								);
    
    grid_8450.getColumnModel().setRenderer(2,function(val,meta,registro)
                                            {
                                                meta.attr='style="padding:7px;height: auto;    white-space: normal;";';
                                                return val;
                                            }
    								);
  


}

function mostrarVentanaAgregarConcepto()
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
                                                            html:'Partida:'
                                                        }	,
                                                        {
                                                        	x:100,
                                                            y:5,
                                                            width:60,
                                                            enableKeyEvents :true,
                                                            xtype:'numberfield',
                                                            allowDecimals:false,
                                                            allowNegative:false,
                                                            maxLength:4,
                                                            id:'txtPartida',
                                                            listeners:	{
                                                                            keypress:function(txt,e)
                                                                                {
                                                                                	
                                                                                    if(e.charCode=='13')
                                                                                    {
                                                                                    	if(txt.getValue()=='')
                                                                                        	return;
                                                                                    	if((txt.getValue()+'').length!=4)
                                                                                        {
                                                                                        	function respAux()
                                                                                            {
                                                                                            	txt.focus();
                                                                                            }
                                                                                        	msgBox('La partida debe ser de 4 d&iacute;gitos',respAux);
                                                                                        	return;
                                                                                        }
                                                                                        if(txt.ultimaBusqueda!=txt.getValue())
                                                                                        {
                                                                                            buscarPartida(txt.getValue());
                                                                                        }
                                                                                    }
                                                                                },
                                                                            blur:function(txt)
                                                                                {
                                                                                	if(txt.getValue()=='')
                                                                              			return;
                                                                                    if((txt.getValue()+'').length!=4)
                                                                                    {
                                                                                    	function respAux2()
                                                                                        {
                                                                                            txt.focus();
                                                                                        }
                                                                                        msgBox('La partida debe ser de 4 d&iacute;gitos',respAux2);
                                                                                        return;
                                                                                    }
                                                                                    if(txt.ultimaBusqueda!=txt.getValue())
                                                                                    {
                                                                                        buscarPartida(txt.getValue());
                                                                                    }
                                                                                    
                                                                                }
                                                                        }
                                                            
                                                        },
                                                        {
                                                        	x:180,
                                                            y:10,
                                                            html:'<span id="lblPartida" style="color:#900"></span>'
                                                        }	,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Concepto:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            xtype:'textarea',
                                                            width:750,
                                                            height:100,
                                                            id:'txtConcepto'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:200,
                                                            html:'Monto:'
                                                        },
                                                        {
                                                        	x:100,
                                                            y:195,
                                                            xtype:'numberfield',
                                                            width:100,
                                                            allowDecimals:false,
                                                            allowNegative:false,
                                                            id:'txtMonto'
                                                        }	
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar concepto',
										width: 800,
										height:330,
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
                                                                	gEx('txtPartida').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var txtPartida=gEx('txtPartida');
                                                                        var txtConcepto=gEx('txtConcepto');
                                                                        var txtMonto=gEx('txtMonto');
                                                                        
                                                                        var pos=obtenerPosFila(gEx('grid_8450').getStore(),'partida',txtPartida.getValue()) ;
                                                                        if(pos!=-1)
                                                                        {
                                                                        	function resp10()
                                                                            {
                                                                            	txtPartida.focus();
                                                                            }
                                                                        	msgBox('Ya existe un concpeto asociado a la partida',resp10);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(txtPartida.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtPartida.focus();
                                                                            }
                                                                            msgBox('Debe ingresar la partida con la cual se asociar&aacute; el concepto',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(txtConcepto.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	txtConcepto.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el concepto a agregar',resp2);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(txtMonto.getValue()=='')
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	txtMonto.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el monto del concepto a agregar',resp3);
                                                                            return;
                                                                        }
                                                                        
                                                                        var reg=crearRegistro(	[
                                                                        							{name: 'idRegistro'},
                                                                                                    {name: 'idReferencia'},
                                                                                                    {name:'capitulo', type:'string'},
                                                                                                    {name:'partida', type:'string'},
                                                                                                    {name:'concepto', type:'string'},
                                                                                                    {name:'costo', type:'string'}
                                                                                                    
                                                                        						]);
                                                                        
																		var r=new reg	(
                                                                        					{
                                                                                            	idRegistro:-1,
                                                                                                idReferencia:-1,
                                                                                                capitulo:lblCapitulo,
                                                                                                partida:txtPartida.getValue(),
                                                                                                concepto:txtConcepto.getValue(),
                                                                                                costo:txtMonto.getValue()
                                                                                            }
                                                                        				)
                                                                                        
                                                                                      
                                                                       	gEx('grid_8450').getStore().add(r);                
                                                                    	ventanaAM.close();
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



function funcionPrepararGuardado()
{
	
    
    return true;
}

function buscarPartida(valor)
{
	gEx('txtPartida').ultimaBusqueda=valor;
	function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
           if(arrResp[1]!='0')
           {
           		lblCapitulo=arrResp[3];
                
                gE('lblPartida').innerHTML=arrResp[2];
           }
           else
           {
           		function respAux()
                {
           			gEx('txtPartida').ultimaBusqueda='';
                    gEx('txtPartida').focus();
                    gE('lblPartida').innerHTML='';
                }
                msgBox('La partida ingresada NO existe',respAux);
           }
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesPlaneacionEstrategica.php',funcAjax, 'POST','funcion=50&idClasificadorObjetoGasto='+iClasificador+
    				'&valor='+valor,true);
}