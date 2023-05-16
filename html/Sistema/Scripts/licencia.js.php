<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$idRegistro=$_GET["iR"];
	
	
	$consulta="SELECT * FROM 000_registroLicencias WHERE idRegistro=".$idRegistro;
	$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
?>

var idRegistro=<?php echo $idRegistro?>;
var claveLicencia='<?php echo $fRegistro["claveLicencia"]?>';
var arrClave=[];
Ext.onReady(inicializar);

function inicializar()
{
	if(claveLicencia!='')
		arrClave=claveLicencia.split('-');
	new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                title: '<span class="letraLicenciaTitulo"><b>Registro de Licencia MAJO</b></span>',
                                                items:	[
                                                            {
                                                            	region:'center',
                                                            	xtype:'panel',
                                                                layout:'absolute',
                                                                items:	[
                                                                			
                                                                			{
                                                                            	x:20,
                                                                                y:10,
                                                                            	xtype:'fieldset',
                                                                                title:'<span class="letraLicencia"><b>Ingrese la Clave de la Licencia a Registrar</b></span>',
                                                                                width:800,
                                                                                layout:'absolute',
                                                                                height:80,
                                                                                items:	[
                                                                                			{
                                                                                            	xtype:'textfield',
                                                                                                x:10,
                                                                                                y:10,
                                                                                                id:'txtClave1',
                                                                                                width:50,
                                                                                                listeners:	{
																												blur:function(ctrl)
                                                                                                                	{
                                                                                                                    	convertirMayuscula(ctrl);
                                                                                                                    }
                                                                                                			}
                                                                                            },
                                                                                            {
                                                                                            	xtype:'label',
                                                                                                x:70,
                                                                                                y:10,
                                                                                                width:50,
                                                                                                html:'-'
                                                                                            },
                                                                                            {
                                                                                            	xtype:'textfield',
                                                                                                x:80,
                                                                                                y:10,
                                                                                                id:'txtClave2',
                                                                                                width:50,
                                                                                                listeners:	{
																												blur:function(ctrl)
                                                                                                                	{
                                                                                                                    	convertirMayuscula(ctrl);
                                                                                                                    }
                                                                                                			}
                                                                                            },
                                                                                            {
                                                                                            	xtype:'label',
                                                                                                x:140,
                                                                                                y:10,
                                                                                                width:50,
                                                                                                html:'-'
                                                                                            },
                                                                                            {
                                                                                            	xtype:'textfield',
                                                                                                x:150,
                                                                                                y:10,
                                                                                                id:'txtClave3',
                                                                                                width:50,
                                                                                                listeners:	{
																												blur:function(ctrl)
                                                                                                                	{
                                                                                                                    	convertirMayuscula(ctrl);
                                                                                                                    }
                                                                                                			}
                                                                                            },
                                                                                            {
                                                                                            	xtype:'label',
                                                                                                x:210,
                                                                                                y:10,
                                                                                                width:50,
                                                                                                html:'-'
                                                                                            },
                                                                                            {
                                                                                            	xtype:'textfield',
                                                                                                x:220,
                                                                                                y:10,
                                                                                                id:'txtClave4',
                                                                                                width:50,
                                                                                                listeners:	{
																												blur:function(ctrl)
                                                                                                                	{
                                                                                                                    	convertirMayuscula(ctrl);
                                                                                                                    }
                                                                                                			}
                                                                                            },
                                                                                            {
                                                                                            	xtype:'label',
                                                                                                x:280,
                                                                                                y:10,
                                                                                                width:50,
                                                                                                html:'-'
                                                                                            },
                                                                                            {
                                                                                            	xtype:'textfield',
                                                                                                x:290,
                                                                                                y:10,
                                                                                                id:'txtClave5',
                                                                                                width:50,
                                                                                                listeners:	{
																												blur:function(ctrl)
                                                                                                                	{
                                                                                                                    	convertirMayuscula(ctrl);
                                                                                                                    }
                                                                                                			}
                                                                                            },
                                                                                            
                                                                                            {
                                                                                            	xtype:'label',
                                                                                                x:350,
                                                                                                y:10,
                                                                                                width:50,
                                                                                                html:'-'
                                                                                            },
                                                                                            {
                                                                                            	xtype:'textfield',
                                                                                                x:360,
                                                                                                y:10,
                                                                                                id:'txtClave6',
                                                                                                width:50,
                                                                                                listeners:	{
																												blur:function(ctrl)
                                                                                                                	{
                                                                                                                    	convertirMayuscula(ctrl);
                                                                                                                    }
                                                                                                			}
                                                                                            },
                                                                                            {
                                                                                            	xtype:'label',
                                                                                                x:420,
                                                                                                y:10,
                                                                                                width:50,
                                                                                                html:'-'
                                                                                            },
                                                                                            {
                                                                                            	xtype:'textfield',
                                                                                                x:430,
                                                                                                y:10,
                                                                                                id:'txtClave7',
                                                                                                width:50,
                                                                                                listeners:	{
																												blur:function(ctrl)
                                                                                                                	{
                                                                                                                    	convertirMayuscula(ctrl);
                                                                                                                    }
                                                                                                			}
                                                                                            },
                                                                                            {
                                                                                            	xtype:'label',
                                                                                                x:490,
                                                                                                y:10,
                                                                                                width:50,
                                                                                                html:'-'
                                                                                            },
                                                                                            {
                                                                                            	xtype:'textfield',
                                                                                                x:500,
                                                                                                y:10,
                                                                                                id:'txtClave8',
                                                                                                width:50,
                                                                                                listeners:	{
																												blur:function(ctrl)
                                                                                                                	{
                                                                                                                    	convertirMayuscula(ctrl);
                                                                                                                    }
                                                                                                			}
                                                                                            },
                                                                                            {
                                                                                            	xtype:'label',
                                                                                                x:560,
                                                                                                y:10,
                                                                                                width:50,
                                                                                                html:'-'
                                                                                            },
                                                                                            {
                                                                                            	xtype:'textfield',
                                                                                                x:570,
                                                                                                y:10,
                                                                                                id:'txtClave9',
                                                                                                width:50,
                                                                                                listeners:	{
																												blur:function(ctrl)
                                                                                                                	{
                                                                                                                    	convertirMayuscula(ctrl);
                                                                                                                    }
                                                                                                			}
                                                                                            },
                                                                                            {
                                                                                            	xtype:'label',
                                                                                                x:630,
                                                                                                y:10,
                                                                                                width:50,
                                                                                                html:'-'
                                                                                            },
                                                                                            {
                                                                                            	xtype:'textfield',
                                                                                                x:640,
                                                                                                y:10,
                                                                                                id:'txtClave10',
                                                                                                width:50,
                                                                                                listeners:	{
																												blur:function(ctrl)
                                                                                                                	{
                                                                                                                    	convertirMayuscula(ctrl);
                                                                                                                    }
                                                                                                			}
                                                                                            },
                                                                                            {
                                                                                            	xtype:'label',
                                                                                                x:700,
                                                                                                y:10,
                                                                                                width:50,
                                                                                                html:'-'
                                                                                            },
                                                                                            {
                                                                                            	xtype:'textfield',
                                                                                                x:710,
                                                                                                y:10,
                                                                                                id:'txtClave11',
                                                                                                width:50,
                                                                                                listeners:	{
																												blur:function(ctrl)
                                                                                                                	{
                                                                                                                    	convertirMayuscula(ctrl);
                                                                                                                    }
                                                                                                			}
                                                                                            }
                                                                                            
                                                                                		]
                                                                            }
                                                                            
                                                                            ,
                                                                            {
                                                                                x:720,
                                                                                width:100,
                                                                                height:30,
                                                                                y:100,
                                                                                xtype:'button',
                                                                                //icon:'../images/icon_big_tick.gif',
                                                                                cls:'btnSIUGJ',
                                                                                text:'Aceptar',
                                                                                handler:function()
                                                                                        {
                                                                                        	var clave='';
                                                                                            var x;
                                                                                            var txtClave;
                                                                                            for(x=1;x<11;x++)
                                                                                            {
                                                                                            	txtClave=gEx('txtClave'+x);
                                                                                                if(txtClave.getValue()=='')
                                                                                                {
                                                                                                	function resp()
                                                                                                    {
                                                                                                    	txtClave.focus();
                                                                                                    }
                                                                                                	msgBox('Debe ingresar la Clave de la Licencia a registrar',resp);
                                                                                                	return;
                                                                                                }
                                                                                                
                                                                                                if(txtClave.getValue()!='')
                                                                                                {
                                                                                                    if(clave=='')
                                                                                                        clave=txtClave.getValue();
                                                                                                    else
                                                                                                        clave+='-'+txtClave.getValue();
                                                                                                }
		
                                                                                            }
                                                                                            
                                                                                            
                                                                                            function funcAjax()
                                                                                            {
                                                                                                var resp=peticion_http.responseText;
                                                                                                arrResp=resp.split('|');
                                                                                                if(arrResp[0]=='1')
                                                                                                {
                                                                                                    var objCad=eval('['+arrResp[1]+']')[0];
                                                                                                    switch(objCad.resultado)
                                                                                                    {
                                                                                                    	case '0':
                                                                                                        	function resp1()
                                                                                                            {
                                                                                                            	gEx('txtClave1').focus();
                                                                                                            }
                                                                                                            msgBox('La Clave de Licencia NO es V&aacute;lida, verifique que la haya ingresado correctamente',resp1)
                                                                                                        	return;
                                                                                                        break;
                                                                                                        case '1':
                                                                                                        	function resp2()
                                                                                                            {
                                                                                                            	regresarPagina();
                                                                                                            }
                                                                                                            msgBox('La Clave de Licencia ha sido Activada Exitosamente',resp2)
                                                                                                        	return;
                                                                                                        break;
                                                                                                        case '2':
                                                                                                        	function resp3()
                                                                                                            {
                                                                                                            	gEx('txtClave1').focus();
                                                                                                            }
                                                                                                            msgBox('Ha ocurrido un error que impide registrar la Clave de Licencia, por favor int&eacute;ntelo m&aacute;s tarde',resp3)
                                                                                                        break;
                                                                                                        case '3':
                                                                                                        	function resp4()
                                                                                                            {
                                                                                                            	gEx('txtClave1').focus();
                                                                                                            }
                                                                                                            msgBox('La Clave de Licencia ya ha sido activado en otro servidor, verifique que la clave sea correctra',resp4)
                                                                                                        break;
                                                                                                        case '4':
                                                                                                        	function resp5()
                                                                                                            {
                                                                                                            	gEx('txtClave1').focus();
                                                                                                            }
                                                                                                            msgBox('Solo se puede registrar una licencia de tipo "Servidor", verifique que la clave sea correctra',resp5)
                                                                                                        break;
                                                                                                    }
                                                                                                    
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                    msgBox('No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente error:'+' <br />'+arrResp[0]);
                                                                                                }
                                                                                            }
                                                                                            obtenerDatosWeb('../paginasFunciones/verifyLicenses.php',funcAjax, 'POST','funcion=2&idRegistro='+idRegistro+'&clave='+clave,true);
                                                                                            
                                                                                            
                                                                                        }
                                                                                
                                                                            },
                                                                            {
                                                                                x:720,
                                                                                width:100,
                                                                                height:30,
                                                                                y:140,
                                                                                id:'btnCancelar',
                                                                                xtype:'button',
                                                                                //icon:'../images/cross.png',
                                                                                cls:'btnSIUGJCancel',
                                                                                text:'Cancelar',
                                                                                handler:function()
                                                                                        {
                                                                                        	function resp(btn)
                                                                                            {
                                                                                            	if(btn=='yes')
                                                                                                {
                                                                                                	regresarPagina();
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer cancelar la operaci&oacute;n',resp);
                                                                                        
                                                                                        
                                                                                        }
                                                                            },
                                                                            {
                                                                            	x:20,
                                                                                y:100,
                                                                            	xtype:'fieldset',
                                                                                title:'<span class="letraLicencia"><b>Informaci&oacute;n de la Licencia</b></span>',
                                                                                width:600,
                                                                                layout:'absolute',
                                                                                height:350,
                                                                                items:	[
                                                                                			{
                                                                                            	xtype:'label',
                                                                                            	x:10,
                                                                                                y:10,
                                                                                                html:'<span style="font-size:12px" class="letraLicenciaSub"><b>Situaci&oacute;n Actual de la Licencia:</b></span>'
                                                                                            },
                                                                                            {
                                                                                            	xtype:'label',
                                                                                            	x:220,
                                                                                                y:10,
                                                                                                html:'<span style="font-size:12px" id="lblEtiqueta1" class="letraLicencia"></span>'
                                                                                            },
                                                                                			{
                                                                                            	xtype:'label',
                                                                                            	x:10,
                                                                                                y:40,
                                                                                                html:'<span style="font-size:12px" class="letraLicenciaSub"><b>Titular de la Licencia:</b></span>'

                                                                                            },
                                                                                            {
                                                                                            	xtype:'label',
                                                                                            	x:220,
                                                                                                y:40,
                                                                                                 html:'<span style="font-size:12px" id="lblEtiqueta2" class="letraLicencia"></span>'
                                                                                            },
                                                                                			{
                                                                                            	xtype:'label',
                                                                                            	x:10,
                                                                                                y:70,
                                                                                                html:'<span style="font-size:12px" class="letraLicenciaSub"><b>Tipo de Uso:</b></span>'

                                                                                            },
                                                                                            {
                                                                                            	xtype:'label',
                                                                                            	x:220,
                                                                                                y:70,
                                                                                                html:'<span style="font-size:12px" id="lblEtiqueta3" class="letraLicencia"></span>'
                                                                                            },
                                                                                			{
                                                                                            	xtype:'label',
                                                                                            	x:10,
                                                                                                y:100,
                                                                                                html:'<span style="font-size:12px" class="letraLicenciaSub"><b>Clase de Licencia:</b></span>'

                                                                                            },
                                                                                            {
                                                                                            	xtype:'label',
                                                                                            	x:220,
                                                                                                y:100,
                                                                                                 html:'<span style="font-size:12px" id="lblEtiqueta4" class="letraLicencia"></span>'
                                                                                            },
                                                                                			{
                                                                                            	xtype:'label',
                                                                                            	x:10,
                                                                                                y:130,
                                                                                                html:'<span style="font-size:12px" class="letraLicenciaSub"><b>Vigencia de la Licencia:</b></span>'

                                                                                            },
                                                                                            {
                                                                                            	xtype:'label',
                                                                                            	x:220,
                                                                                                y:130,
                                                                                                html:'<span style="font-size:12px" id="lblEtiqueta5" class="letraLicencia"></span>'
                                                                                            },
                                                                                			{
                                                                                            	xtype:'label',
                                                                                            	x:10,
                                                                                                y:160,
                                                                                                html:'<span style="font-size:12px" class="letraLicenciaSub"><b>Fecha de Inicio Vigencia:</b></span>'

                                                                                            },
                                                                                             {
                                                                                            	xtype:'label',
                                                                                            	x:220,
                                                                                                y:160,
                                                                                                 html:'<span style="font-size:12px" id="lblEtiqueta6" class="letraLicencia"></span>'
                                                                                            },
                                                                                			{
                                                                                            	xtype:'label',
                                                                                            	x:10,
                                                                                                y:190,
                                                                                                html:'<span style="font-size:12px" class="letraLicenciaSub"><b>Fecha de T&eacute;rmino Vigencia:</b></span>'

                                                                                            },
                                                                                             {
                                                                                            	xtype:'label',
                                                                                            	x:220,
                                                                                                y:190,
                                                                                                 html:'<span style="font-size:12px" id="lblEtiqueta7" class="letraLicencia"></span>'
                                                                                            },
                                                                                			{
                                                                                            	xtype:'label',
                                                                                            	x:10,
                                                                                                y:220,
                                                                                                html:'<span style="font-size:12px" class="letraLicenciaSub"><b>Descripci&oacute;n del Producto:</b></span>'

                                                                                            },
                                                                                            {
                                                                                            	xtype:'label',
                                                                                            	x:220,
                                                                                                y:220,
                                                                                                 html:'<span style="font-size:12px" id="lblEtiqueta8" class="letraLicencia"></span>'
                                                                                            },
                                                                                			{
                                                                                            	xtype:'label',
                                                                                            	x:10,
                                                                                                y:250,
                                                                                                html:'<span style="font-size:12px" class="letraLicenciaSub"><b>Estado Activaci&oacute;n en Servidor:</b></span>'

                                                                                            },
                                                                                            {
                                                                                            	xtype:'label',
                                                                                            	x:220,
                                                                                                y:250,
                                                                                                 html:'<span style="font-size:12px" id="lblEtiqueta9" class="letraLicencia"></span>'
                                                                                            },
                                                                                			{
                                                                                            	xtype:'label',
                                                                                            	x:10,
                                                                                                y:280,
                                                                                                html:'<span style="font-size:12px" class="letraLicenciaSub"><b>Direcci&oacute;n MAC de Servidor:</b></span>'

                                                                                            },
                                                                                            {
                                                                                            	xtype:'label',
                                                                                            	x:220,
                                                                                                y:280,
                                                                                                 html:'<span style="font-size:12px" id="lblEtiqueta10" class="letraLicencia"></span>'
                                                                                            }
                                                                                		]
                                                                            }
                                                                            
                                                                		]
                                                            }
                                                        ]
                                            }
                                         ]
                            }
                        ) 

	gEx('txtClave1').focus(false,500);
    
    if(arrClave.length>0)
    {
    	var x;
        var valor;
        for(x=1;x<12;x++)
        {
        	
            if(x<=arrClave.length)
        		gEx('txtClave'+x).setValue(arrClave[x-1]);
        }
        consultarClaveLicencia();
    }
}


function convertirMayuscula(ctrl)
{
	ctrl.setValue(ctrl.getValue().toUpperCase());
}


function consultarClaveLicencia()
{
	var x;
    var txtClave;
    var clave='';
    for(x=1;x<11;x++)
    {
        txtClave=gEx('txtClave'+x);
        if(txtClave.getValue()=='')
        {
            function resp()
            {
                txtClave.focus();
            }
            msgBox('Debe ingresar la clave de la licencia',resp);
            return;
        }
        
        if(clave=='')
            clave=txtClave.getValue();
        else
            clave+=txtClave.getValue();
    }
    
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var objCad=eval('['+arrResp[1]+']')[0];
            var lblEtiqueta1=gE('lblEtiqueta1');
            var lblEtiqueta2=gE('lblEtiqueta2');
            var lblEtiqueta3=gE('lblEtiqueta3');
            var lblEtiqueta4=gE('lblEtiqueta4');
            var lblEtiqueta5=gE('lblEtiqueta5');
            var lblEtiqueta6=gE('lblEtiqueta6');
            var lblEtiqueta7=gE('lblEtiqueta7');
            var lblEtiqueta8=gE('lblEtiqueta8');
            var lblEtiqueta9=gE('lblEtiqueta9');
            var lblEtiqueta10=gE('lblEtiqueta10');
            
            
            switch(objCad.resultado)
            {
                case '0':
                    lblEtiqueta1.innerHTML='<span style="color:#F00">Clave de Licencia NO V&aacute;lida</span>';
                    lblEtiqueta2.innerHTML='';
                    lblEtiqueta3.innerHTML='';
                    lblEtiqueta4.innerHTML='';
                    lblEtiqueta5.innerHTML='';
                    lblEtiqueta6.innerHTML='';
                    lblEtiqueta7.innerHTML='';
                    lblEtiqueta8.innerHTML='';
                    lblEtiqueta9.innerHTML='';
                    lblEtiqueta10.innerHTML='';
                    return;
                break;
                case '1':
                    lblEtiqueta1.innerHTML='<span style="color:#030">Clave de Licencia V&aacute;lida: Autorizada</span>';
                break;
                case  '2':
                    lblEtiqueta1.innerHTML='<span style="color:#000A64">Clave de Licencia V&aacute;lida: En espera de Autoriaci&oacute;n</span>';
                break;
                 case  '3':
                    lblEtiqueta1.innerHTML='<span style="color:#F00">Clave de Licencia Suspendida</span>';
                break;
            }
            
            lblEtiqueta2.innerHTML=objCad.titularLicencia;
            lblEtiqueta3.innerHTML=objCad.tipoUso=='1'?'Licencia de Servidor':'Licencia de Usuario Final';
            lblEtiqueta4.innerHTML=objCad.claseLicencia;
            lblEtiqueta5.innerHTML=objCad.vigenciaLicencia=='1'?'Permanente':'Limitado';
            lblEtiqueta6.innerHTML=objCad.fechaInicioVigencia==''?'------':Date.parseDate(objCad.fechaInicioVigencia,'Y-m-d').format('d/m/Y');
            lblEtiqueta7.innerHTML=objCad.vigenciaLicencia=='1'?'------':Date.parseDate(objCad.fechaFinVigencia,'Y-m-d').format('d/m/Y');
            lblEtiqueta8.innerHTML=objCad.descripcionProducto;
            lblEtiqueta9.innerHTML=objCad.MACAddress==''?'<span style="color:#900">NO Activado</span>':'<span style="color:#030">Activado</span>';
            lblEtiqueta10.innerHTML=objCad.MACAddress=='-------------------'?'':objCad.MACAddress;
            
        }
        else
        {
            msgBox('No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente error:'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/verifyLicenses.php',funcAjax, 'POST','funcion=1&clave='+clave,true);
}