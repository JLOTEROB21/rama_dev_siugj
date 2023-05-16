<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$ugj=$_GET["uG"];
	$consulta="SELECT claveElemento,nombreElemento FROM 1018_catalogoVarios WHERE tipoElemento=21 and claveElemento<>0";
	$arrTipoDiligencias=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT valor,texto FROM 1004_siNo ORDER BY valor DESC";
	$arrSiNo=$con->obtenerFilasArreglo($consulta);
	
	$arrParteProcesal="";
	$consulta="SELECT id__414_tablaDinamica, parteProcesal, figuraJuridica FROM _414_tablaDinamica ORDER BY parteProcesal";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT iEspecificacion,etEspecificacion FROM _414_gEspecificacion WHERE idReferencia=".$fila[0]." ORDER BY etEspecificacion";
		$arrEspecificacion=$con->obtenerFilasArreglo($consulta);
		$o="['".$fila[0]."','".cv($fila[1])."',".$arrEspecificacion.",'".$fila[2]."']";
		if($arrParteProcesal=="")
			$arrParteProcesal=$o;
		else
			$arrParteProcesal.=",".$o;
	}
	
	$consulta="SELECT u.idUsuario,us.Nombre FROM 807_usuariosVSRoles u,801_adscripcion a,800_usuarios us WHERE codigoRol IN('32_0','38_0')
				AND a.idUsuario=u.idUsuario AND us.idUsuario=u.idUsuario AND a.Institucion='".$ugj."' ORDER BY Nombre";
	
	$arrResponsableDiligencia=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT claveElemento,nombreElemento FROM 1018_catalogoVarios WHERE tipoElemento=22 order by claveElemento";
	$arrResultadoDiligencias=$con->obtenerFilasArreglo($consulta);

	
	
	$consulta="SELECT id__415_tablaDinamica,medioNotificacion FROM _415_tablaDinamica order by prioridad";
	$aMediosNotificacion=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idDetalle, descripcion FROM _415_gEspecificaciones order by prioridad";
	$aMediosNotificacionDetalle2=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT DISTINCT iEspecificacion,etEspecificacion FROM _414_gEspecificacion";
	$arrEspecificacionParteProcesal=$con->obtenerFilasArreglo($consulta);
	
?>
var arrEspecificacionParteProcesal=<?php echo $arrEspecificacionParteProcesal?>;
var arrResultadoDiligencias=<?php echo $arrResultadoDiligencias?>;
var arrResultadoDiligenciasMP=arrResultadoDiligencias;

var arrResponsableDiligencia=<?php echo $arrResponsableDiligencia?>;
var arrParteProcesal=[<?php echo $arrParteProcesal?>];
var arrTipoActa=[['1','Derivada de Determinaci\xF3n'],['2','Derivada de Audiencia']];
var aMediosNotificacionCatalogo=<?php echo $aMediosNotificacion ?>;
var arrTipoDiligencias=<?php echo $arrTipoDiligencias?>;
var arrSiNo=<?php echo $arrSiNo?>;
var aMedioNotificacion=[];
var aMediosNotificacionDetalle2=<?php echo $aMediosNotificacionDetalle2?>;
var datosNotificacion='';
Ext.onReady(inicializar);

function inicializar()
{
	arrTipoDiligencias.splice(arrTipoDiligencias.length,0,['0','OTRO']);
	var arrTipoAudiencia=eval(bD(gE('arrAudiencias').value));
	var cmbTipoActa=crearComboExt('cmbTipoActa',arrTipoActa,330,5,200);
    cmbTipoActa.on('select',function(cmb,registro)
    						{
                            	switch(registro.data.id)
                                {
                                	case '1':
                                    	gEx('lblNombreDeterminacion').show();
                                        gEx('txtNombreDeterminacion').show();
                                        gEx('lblFechaDeterminacion').setText('Fecha de la determinaci&oacute;n:',false);
                                        gEx('lblFechaDeterminacion').show();
                                        gEx('dteFechaDterminacion').show();
                                        gEx('dteFechaDterminacion').setValue('<?php echo date("Y-m-d")?>');
                                        gEx('dteFechaDterminacion').enable();
                                        gEx('lblAudienciaDeriva').hide();
                                        gEx('cmbAudienciaDeriva').setValue('');
                                        gEx('cmbAudienciaDeriva').hide();
                                        gEx('txtNombreDeterminacion').focus(false,500);
                                        
                                    break;
                                    case '2':
                                    	gEx('lblNombreDeterminacion').hide();
                                        gEx('txtNombreDeterminacion').hide();
                                        gEx('txtNombreDeterminacion').setValue('');
                                        gEx('lblFechaDeterminacion').show();
                                        gEx('dteFechaDterminacion').setValue('');
                                        gEx('dteFechaDterminacion').disable();
                                        gEx('lblFechaDeterminacion').setText('Fecha del auto:');
                                        gEx('dteFechaDterminacion').show();                                        
                                        gEx('lblAudienciaDeriva').show();
                                        gEx('cmbAudienciaDeriva').show();
                                        gEx('cmbAudienciaDeriva').focus(false,500);
                                    break;
                                }
                                
                            }
    				)
    var cmbAudienciaDeriva=crearComboExt('cmbAudienciaDeriva',arrTipoAudiencia,220,35,480);
    cmbAudienciaDeriva.on('select',function(cmb,registro)
   									{
   										gEx('dteFechaDterminacion').setValue(registro.data.valorComp);
   									}
    					)
    cmbAudienciaDeriva.hide();
	new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                
                                                title:'Carpeta Judicial [<span style="color:#900"><b>'+
                                                		gE('carpetaAdministrativa').value+'</b></span>]&nbsp;&nbsp;Acta circunstanciada [<b><span id="lblAccion" style="color:#900">'+
                                                        (gE('idActa').value=='-1'?'Nuevo':'Modificar')+'</span></b>]',
                                                items:	[
                                                            {
                                                            	xtype:'panel',
                                                                region:'north',
                                                                height:160,
                                                                width:'100%',
                                                                baseCls: 'x-plain',
                                                                layout:'absolute',
                                                                border:false,
                                                                frame:false,
                                                                tbar:	[
                                                                			{
                                                                                icon:'../images/salir.gif',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Regresar',
                                                                                handler:function()
                                                                                        {
                                                                                            regresarPagina();
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/guardar.PNG',
                                                                                cls:'x-btn-text-icon',
                                                                                id:'btnSaveActa',
                                                                                text:'Guardar acta',
                                                                                handler:function()
                                                                                        {
                                                                                            var dteFechaActa=gEx('dteFechaActa');
                                                                                            var cmbTipoActa=gEx('cmbTipoActa');
                                                                                            var lblNombreDeterminacion=gEx('txtNombreDeterminacion');
                                                                                            var fechaDeterminacion=gEx('dteFechaDterminacion').getValue();
                                                                                            var idAudiencia=gEx('cmbAudienciaDeriva').getValue();
                                                                                            var comentarios=gEx('txtComentarios').getValue();
                                                                                            
                                                                                            if(dteFechaActa.getValue()=='')
                                                                                            {
                                                                                            	function resp()
                                                                                                {
                                                                                                	dteFechaActa.focus();
                                                                                                }
                                                                                                msgBox('Debe indicar la fecha del acta',resp);
                                                                                                return;
                                                                                            }
                                                                                            
                                                                                            if(cmbTipoActa.getValue()=='')
                                                                                            {
                                                                                            	function resp2()
                                                                                                {
                                                                                                	cmbTipoActa.focus();
                                                                                                }
                                                                                                msgBox('Debe el tipo de acta a registrar',resp2);
                                                                                                return;
                                                                                            }                                                                                            
                                                                                            
                                                                                            if(cmbTipoActa.getValue()=='1')
                                                                                            {
                                                                                            	if(lblNombreDeterminacion.getValue()=='')
                                                                                                {
                                                                                                    function resp3()
                                                                                                    {
                                                                                                        lblNombreDeterminacion.focus();
                                                                                                    }
                                                                                                    msgBox('Debe indicar el nombre de la determinaci&oacute;n',resp3);
                                                                                                    return;
                                                                                                }
                                                                                                
                                                                                                if(fechaDeterminacion=='')
                                                                                                {
                                                                                                    function resp4()
                                                                                                    {
                                                                                                        gEx('dteFechaDterminacion').focus();
                                                                                                    }
                                                                                                    msgBox('Debe indicar la fecha de la determinaci&oacute;n',resp4);
                                                                                                    return;
                                                                                                }
                                                                                                
                                                                                                
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                            	if(idAudiencia=='')
                                                                                                {
                                                                                                    function resp5()
                                                                                                    {
                                                                                                        gEx('cmbAudienciaDeriva').focus();
                                                                                                    }
                                                                                                    msgBox('Debe indicar la audiencia de la cual deriva la acta a registrar',resp5);
                                                                                                    return;
                                                                                                }
                                                                                                
                                                                                                if(fechaDeterminacion=='')
                                                                                                {
                                                                                                    function resp14()
                                                                                                    {
                                                                                                        gEx('dteFechaDterminacion').focus();
                                                                                                    }
                                                                                                    msgBox('Debe indicar la fecha del auto',resp14);
                                                                                                    return;
                                                                                                }
                                                                                                
                                                                                                
                                                                                            }
                                                                                            fechaDeterminacion=fechaDeterminacion.format('Y-m-d');
                                                                                            var cadObj='{"idActa":"'+gE('idActa').value+'","fechaActa":"'+dteFechaActa.getValue().format('Y-m-d')+'","tipoActa":"'+cmbTipoActa.getValue()+
                                                                                            		'","idEventoAudiencia":"'+idAudiencia+'","nombreDeterminacion":"'+cv(lblNombreDeterminacion.getValue())+
                                                                                                    '","fechaDeterminacion":"'+fechaDeterminacion+'","comentariosAdicionales":"'+
                                                                                                    cv(gEx('txtComentarios').getValue())+'","carpetaAdministrativa":"'+gE('carpetaAdministrativa').value+'"}';
																							
                                                                                            
                                                                                            function funcAjax()
                                                                                            {
                                                                                                var resp=peticion_http.responseText;
                                                                                                arrResp=resp.split('|');
                                                                                                if(arrResp[0]=='1')
                                                                                                {
                                                                                                    gE('idActa').value=arrResp[1];
                                                                                                    gE('lblAccion').innerHTML='Modificar';
                                                                                                    msgBox('Los datos del acta han sido actualizados correctamente');
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                }
                                                                                            }
                                                                                            obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=123&cadObj='+cadObj,true);                                                                                               
                                                                                            
                                                                                        }
                                                                                
                                                                            },
                                                                            {
                                                                                icon:'../images/page_white_magnify.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:true,
                                                                                id:'btnViewActa',
                                                                                text:'Visualizar acta circunstanciada',
                                                                                handler:function()
                                                                                        {
                                                                                        	visualizarActaCircunstanciada();
                                                                                        }
                                                                                
                                                                            },
                                                                            '-',
                                                                            {
                                                                                icon:'../images/page_white_stack.png',
                                                                                cls:'x-btn-text-icon',
                                                                                id:'btnBuildActa',
                                                                                text:'Generar acta circunstanciada',
                                                                                handler:function()
                                                                                        {
                                                                                        	if(gE('idActa').value=='-1')
                                                                                            {
                                                                                            	msgBox('Primero debe guardar la informaci&oacute;n b&aacute;sica del acta');
                                                                                            	return;
                                                                                            }
                                                                                        
                                                                                        	objConf={
                                                                                           				ancho:900,
                                                                                           				alto:500,
                                                                                            			tipoDocumento:214,
                                                                                                        idActa:gE('idActa').value,
                                                                                                        idFormulario:-1,
                                                                                                        idRegistro: gE('idActa').value,
                                                                                                        urlConfiguracion:'../../modulosEspeciales_SGJP/Scripts/configCKEditorZoom.js',
                                                                                                        functionAfterLoadDocument:function()
                                                                                                        						{
                                                                                                        							setTimeout(function()
                                                                                                       											{
                                                                                                       												var body = CKEDITOR.instances.txtDocumento.editable().$;
                                                                                                        							
																																					var value = 113;

																																					body.style.MozTransformOrigin = "top left";
																																					body.style.MozTransform = "scale(" + (value/100)  + ")";

																																					body.style.WebkitTransformOrigin = "top left";
																																					body.style.WebkitTransform = "scale(" + (value/100)  + ")";

																																					body.style.OTransformOrigin = "top left";
																																					body.style.OTransform = "scale(" + (value/100)  + ")";

																																					body.style.TransformOrigin = "top left";
																																					body.style.Transform = "scale(" + (value/100)  + ")";
																																					// IE
																																					body.style.zoom = value/100;
                                                                                                      											
                                                                                                      												console.log(CKEDITOR.plugins);
                                                                                                       											},200
                                                                                                        									)
                                                                                                        							

																																	
                                                                                                        						}
                                                                                                        
                                                                                                     };
                                                                                            
                                                                                            mostrarVentanaGeneracionDocumentos(objConf);
                                                                                        }
                                                                                
                                                                            }
                                                                		],
                                                                items:	[
                                                                			{
                                                                            	x:10,
                                                                                y:10,
                                                                                xtype:'label',
                                                                                html:'Fecha del acta:'
                                                                            },
                                                                            {
                                                                            	x:125,
                                                                                y:5,
                                                                                id:'dteFechaActa',
                                                                                value:'<?php echo date("Y-m-d")?>',
                                                                                xtype:'datefield'
                                                                                
                                                                            },
                                                                            {
                                                                            	x:260,
                                                                                y:10,
                                                                                xtype:'label',
                                                                                html:'Tipo acta:'
                                                                            },
                                                                            cmbTipoActa,
                                                                            {
                                                                            	x:10,
                                                                                y:40,
                                                                                id:'lblNombreDeterminacion',
                                                                                hidden:true,
                                                                                xtype:'label',
                                                                                html:'Nombre de la determinaci&oacute;n:'
                                                                            },
                                                                            {
                                                                            	id:'txtNombreDeterminacion',
                                                                            	xtype:'textfield',
                                                                                width:480,
                                                                                hidden:true,
                                                                                x:220,
                                                                                y:35
                                                                            },
                                                                            {
                                                                            	x:730,
                                                                                y:40,
                                                                                id:'lblFechaDeterminacion',
                                                                                hidden:true,
                                                                                xtype:'label',
                                                                                html:'Fecha de la determinaci&oacute;n:'
                                                                            },
                                                                            {
                                                                            	x:10,
                                                                                y:40,
                                                                                hidden:true,
                                                                                xtype:'label',
                                                                                id:'lblAudienciaDeriva',
                                                                                html:'Audiencia de la cual deriva:'
                                                                            },
                                                                            cmbAudienciaDeriva,
                                                                            {
                                                                            	xtype:'datefield',
                                                                                x:920,
                                                                                y:35,
                                                                                id:'dteFechaDterminacion',
                                                                                hidden:true,
                                                                                value:'<?php echo date("Y-m-d")?>'
                                                                            },
                                                                            {
                                                                            	x:10,
                                                                                y:70,
                                                                                xtype:'label',
                                                                                html:'Comentarios adicionales:'
                                                                            },
                                                                            {
                                                                            	xtype:'textarea',
                                                                                id:'txtComentarios',
                                                                                width:700,
                                                                                height:50,
                                                                                x:220,
                                                                                y:65
                                                                            }
                                                                		]
                                                            },
                                                            {
                                                            	xtype:'panel',
                                                                region:'center',
                                                                layout:'border',
                                                                items:	[
                                                                			crearGridDiligencias()
                                                                		]
                                                            }
                                                        ]
                                            }
                                         ]
                            }
                        )   
	arrResponsableDiligencia.splice(arrResponsableDiligencia.length,0,['0','OTRO']);
   
    datosNotificacion=eval(bD(gE('datosNotificacion').value));
    if(datosNotificacion.length>0)
    {
    	
    	var dActa=datosNotificacion[0];
        gEx('dteFechaActa').setValue(dActa.fechaActa);
        cmbTipoActa.setValue(dActa.tipoActa);
        dispararEventoSelectCombo('cmbTipoActa');
        gEx('txtNombreDeterminacion').setValue(dActa.nombreDeterminacion);
        gEx('dteFechaDterminacion').setValue(dActa.fechaDeterminacion);
        gEx('cmbAudienciaDeriva').setValue(dActa.idEventoAudiencia);
        dispararEventoSelectCombo('cmbAudienciaDeriva');
        gEx('txtComentarios').setValue(dActa.comentariosAdicionales);
        
    }
    
    if(gE('sL').value=='1')
	    establecerSoloLectura();
    

    
}	

function crearGridDiligencias()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idDiligencia'},
                                                        {name: 'fechaCreacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'fechaDiligencia', type:'date', dateFormat:'Y-m-d'},
		                                                {name: 'tipoDiligencia'},
                                                        {name: 'otroTipoDiligencia'},
		                                                {name: 'idParteProcesal'},
                                                        {name: 'idDetalleParteProcesal'},
		                                                {name: 'idNombreParteProcesal'},
                                                        {name: 'nombreParte'},                                                        
                                                        {name: 'exposicionDiligencia'},
                                                        {name: 'lblNombreParteProcesal'},
                                                        {name: 'idResponsableDiligencia'},
                                                        {name: 'lblOtroResponsable'},
                                                        {name: 'arrMediosNotificacion'},
                                                        {name: 'orden'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_SGP.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'idDiligencia', direction: 'ASC'},
                                                            groupField: 'idDiligencia',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='121';
                                        proxy.baseParams.idActa=gE('idActa').value;
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            {
                                                                header:'ID Diligencia',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'idDiligencia'
                                                            },
                                                            {
                                                                header:'Fecha de la diligencia',
                                                                width:130,
                                                                sortable:true,
                                                                dataIndex:'fechaDiligencia',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y');
                                                                        }
                                                            },
                                                            {
                                                                header:'Fecha de registro',
                                                                width:130,
                                                                sortable:true,
                                                                dataIndex:'fechaCreacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y H:i:s');
                                                                        }
                                                            },
                                                            {
                                                                header:'Tipo diligencia',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'tipoDiligencia',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var lblTipoDiligencia=formatearValorRenderer(arrTipoDiligencias,val);
                                                                            if(parseInt(val)==0)
                                                                            {
                                                                            	lblTipoDiligencia+=': '+registro.data.otroTipoDiligencia;
                                                                            }
                                                                        	return mostrarValorDescripcion(lblTipoDiligencia);
                                                                        }
                                                            },
                                                            {
                                                                header:'Parte procesal',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'idParteProcesal',
                                                                renderer:function(val,meta,registro)
                                                                		{
																			var lblParteProcesal='';
                                                                            lblParteProcesal=formatearValorRenderer(arrParteProcesal,val);
                                                                            if(registro.data.idDetalleParteProcesal!='')
                                                                            {
                                                                            	lblParteProcesal+=' ('+formatearValorRenderer(arrEspecificacionParteProcesal,registro.data.idDetalleParteProcesal)+')';
                                                                            	
                                                                            }
                                                                        	return mostrarValorDescripcion(lblParteProcesal);
                                                                        }
                                                            },
                                                            {
                                                                header:'Nombre del destinatario',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'nombreParte',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	if(val!='')
                                                                            	return val;
                                                                            return registro.data.lblNombreParteProcesal;
                                                                        }
                                                            },
                                                            
                                                            
                                                            
                                                            
                                                            {
                                                                header:'Se contact&oacute; al destinatario',
                                                                width:180,
                                                                sortable:true,
                                                                dataIndex:'responsableDiligencia',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var x;
                                                                            var fila;
                                                                           
                                                                            var nNo=0;
                                                                            var nNA=0;
                                                                            for(x=0;x<registro.data.arrMediosNotificacion.length;x++)
                                                                            {
                                                                                fila=registro.data.arrMediosNotificacion[x];
                                                                                
                                                                                
                                                                                switch(parseInt(fila.resultado))
                                                                                {
                                                                                	case 1:
                                                                                    	return '<span style="color:#030"><b>S&iacute;</b></span>';
                                                                                    break;
                                                                                    case 2:
                                                                                    	nNo++;
                                                                                    break;
                                                                                    case 3:
                                                                                    	nNo++;
                                                                                    break;
                                                                                }
                                                                                
                                                                                   
                                                                            }
                                                                            if(nNA>0)
                                                                            {
                                                                                return '<span style="color:#900"><b>Indeterminado</b></span>';
                                                                            }
                                                                            else
                                                                            {
                                                                                return '<span style="color:#900"><b>No</b></span>';
                                                                            }
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gDiligencias',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : false,      
                                                                tbar:	[
                                                                			{
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                id:'btnAddDiligencia',
                                                                                text:'Agregar diligencia',
                                                                                handler:function()
                                                                                        {
                                                                                        	if(gE('idActa').value=='-1')
                                                                                            {
                                                                                            	msgBox('Debe guardar primero la informaci&oacute;n b&aacute;sica del acta');
                                                                                            	return;
                                                                                            }
                                                                                            mostrarVentanaAgregarDiligencia();
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/pencil.png',
                                                                                cls:'x-btn-text-icon',
                                                                                id:'btnModifyDiligencia',
                                                                                text:'Modificar diligencia',
                                                                                handler:function()
                                                                                        {
                                                                                            var fila=gEx('gDiligencias').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar la diligencia que desea modificar');
                                                                                            	return;
                                                                                            }
                                                                                            mostrarVentanaAgregarDiligencia(fila);
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                id:'btnDelDiligencia',
                                                                                text:'Remover diligencia',
                                                                                handler:function()
                                                                                        {
                                                                                            var fila=gEx('gDiligencias').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar la diligencia que desea remover');
                                                                                            	return;
                                                                                            }
                                                                                            
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
                                                                                                            gEx('gDiligencias').getStore().remove(fila);
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=122&iD='+fila.data.idDiligencia,true);
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer remover la diligencia seleccionada?',resp);
                                                                                            return;
                                                                                        }
                                                                                
                                                                            }
                                                                		],                                                          
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :false,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: true,
                                                                                                    enableRowBody:true,
                                                                                                    getRowClass:formatearFilaDiligencia,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
        return 	tblGrid;	
}

function mostrarVentanaAgregarDiligencia(fDiligencia)
{
	
	var arrDiligencias=[];
	var x;
	var desplazamiento=0;
	if(!fDiligencia)
		desplazamiento=1;
	for(x=1;x<=gEx('gDiligencias').getStore().getCount()+desplazamiento;x++)
	{
		arrDiligencias.push([x,x]);
	}
	var cmbOrden=crearComboExt('cmbOrden',arrDiligencias,180,290,130);
	cmbOrden.setValue(gEx('gDiligencias').getStore().getCount()+desplazamiento);
	var cmbTipoDiligencia=crearComboExt('cmbTipoDiligencia',arrTipoDiligencias,400,10,200);
    cmbTipoDiligencia.on('select',function(cmb,registro)
    								{
                                    	gEx('txtOtroTipoDiligencia').hide();
                                        gEx('txtOtroTipoDiligencia').setValue('');
                                        if(registro.data.id=='0')
                                        {
                                        	gEx('txtOtroTipoDiligencia').show();
                                            gEx('txtOtroTipoDiligencia').focus(false,500);
                                        }
                                    }
    					)
    var cmbParteProcesal=crearComboExt('cmbParteProcesal',arrParteProcesal,140,40,295);
    cmbParteProcesal.on('select',function(cmb,registro)
    								{
                                    	if(registro.data.valorComp.length>0)
                                        {
                                        	cmbTipoParteProcesal.setValue('');
                                            cmbTipoParteProcesal.getStore().loadData(registro.data.valorComp);
                                            cmbTipoParteProcesal.show();
                                        }
                                        else
                                        {
                                        	cmbTipoParteProcesal.setValue('');
                                        	cmbTipoParteProcesal.hide();
                                        }
                                        
                                        var pos=existeValorMatriz(arrParteProcesal,registro.data.id);
                                        if(arrParteProcesal[pos][3]!='')
                                        {
                                        	function funcAjax()
                                            {
                                                var resp=peticion_http.responseText;
                                                arrResp=resp.split('|');
                                                if(arrResp[0]=='1')
                                                {
                                                 	var arrDatos=eval(arrResp[1]);   
                                                    arrDatos.splice(arrDatos.length,0,['0','OTRO']);
                                                    gEx('txtNombre').setValue('');
                                                    gEx('txtNombre').hide();
                                                    gEx('cmbNombre').setValue('');
                                                    gEx('cmbNombre').show();
                                                    gEx('cmbNombre').getStore().loadData(arrDatos);
                                                }
                                                else
                                                {
                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                }
                                            }
                                            obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=118&cA='+
                                            			gE('carpetaAdministrativa').value+'&fJ='+arrParteProcesal[pos][3],true);

                                        }
                                        else
                                        {
                                        	gEx('cmbNombre').setValue('');
                                            gEx('cmbNombre').hide();
                                            gEx('txtNombre').setPosition(140,70);
                                            gEx('txtNombre').show();
                                            gEx('txtNombre').setWidth(400);
                                        }
                                        
                                        
                                    }
    					)
    var cmbTipoParteProcesal=crearComboExt('cmbTipoParteProcesal',[],450,40,180);
    cmbTipoParteProcesal.hide();
    var cmbMedioNotificacion=crearComboExt('cmbMedioNotificacion',[],140,105,200);
    var cmbDetalleMedioNotificacion=crearComboExt('cmbDetalleMedioNotificacion',[],350,105,250);
    var cmbResultadoDiligencia=crearComboExt('cmbResultadoDiligencia',[],180,295,350);
    var cmbResponsableDiligencia=crearComboExt('cmbResponsableDiligencia',arrResponsableDiligencia,180,100,280);
    cmbResponsableDiligencia.on('select',function(cmb,registro)
    									{
                                        	gEx('txtResponsableDiligencia').setValue('');
                                        	gEx('txtResponsableDiligencia').hide();
                                            if(registro.data.id=='0')
                                            {
                                            	gEx('txtResponsableDiligencia').show();
                                                gEx('txtResponsableDiligencia').focus(false,500);
                                            }
                                            
                                        }
    							)  
    
    var cmbCitatorio=crearComboExt('cmbCitatorio',arrSiNo,260,415,140);
    var cmbNombre=crearComboExt('cmbNombre',[],140,70,300);
    cmbNombre.hide();
    cmbNombre.on('select',function(cmb,registro)
    						{
                            	if(registro.data.id=='0')
                                {
                                	gEx('txtNombre').show();
                                    gEx('txtNombre').setPosition(450,70);
                                    gEx('txtNombre').setWidth(300);
                                    gEx('txtNombre').focus(50,false);
                                }
                                else
                                {
                                	gEx('txtNombre').setValue('');
                                	gEx('txtNombre').hide();
                                }
                            }
    			)
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			{
                                                      		xtype:'tabpanel',
                                                      		baseCls: 'x-plain',
                                                      		id:'panelDiligencia',
                                                      		region:'center',
                                                      		activeTab:1,
                                                            listeners:	{
                                                            				tabchange:function(tp,p)
                                                                                    {
                                                                                    	
                                                                                    	
                                                                                    }
                                                            			},
                                                      		items: 	[
                                                     					{
                                                     						xtype:'panel',
                                                     						baseCls: 'x-plain',
                                                     						defaultType: 'label',
                                                     						title:'Datos Generales',
                                                     						id:'dGenerales',
                                                     						layout:'absolute',
                                                     						items: 	[
                                                    									{
																							x:10,
																							y:15,
																							html:'Fecha de la diligencia:'
																						},
																						{
																							x:140,
																							y:10,
																							id:'dteFechaDiligencia',
																							xtype:'datefield',
																							value:'<?php echo date("Y-m-d")?>'
																						},
																						{
																							x:280,
																							y:15,
																							html:'Tipo de diligencia:'
																						},
																						cmbTipoDiligencia,
																						{
																							x:610,
																							y:10,
																							xtype:'textfield',
																							width:300,
																							hidden:true,
																							id:'txtOtroTipoDiligencia'
																						},
																						{
																							x:10,
																							y:45,
																							html:'Parte procesal:'
																						},
																						cmbParteProcesal,
																						cmbTipoParteProcesal,
																						{
																							x:10,
																							y:75,
																							html:'Nombre de la parte:'
																						},
																						{
																							x:140,
																							y:70,
																							xtype:'textfield',
																							width:400,
																							id:'txtNombre'
																						},
																						cmbNombre,


																						{
																							x:10,
																							y:105,
																							html:'Responsable de la diligencia:'
																						},
																						cmbResponsableDiligencia,
																						{
																							x:470,
																							y:100,
																							width:300,
																							xtype:'textfield',
																							hidden:true,
																							id:'txtResponsableDiligencia'
																						},
																						{
																							x:10,
																							y:135,
																							html:'Medio de notificaci&oacute;n:'
																						},
																						crearGridMedioNotificacion(),
																						{
																							x:10,
																							y:295,
																							html:'Orden de aparici&oacute;n:'
																						},
																						cmbOrden
																						
                                                     								]
                                                     					},
                                                     					{
                                                     						xtype:'panel',
                                                     						baseCls: 'x-plain',
                                                     						defaultType: 'label',
                                                                            id:'exposicion',
                                                     						title:'Exposici&oacute;n de la diligencia',
                                                     						layout:'absolute',
                                                     						items: 	[
                                                    									/*{
																							x:10,
																							y:10,
																							width:900,
																							height:300,
																							xtype:'textarea',
																							id:'txtExposicionDiligencia'
																						}*/
																						{
																							x:10,
																							y:10,
																							html:'<textarea id="txtExposicionDiligencia"></textarea>'
																						}
																						
                                                     								]
                                                     					}
                                                      				]
                                                       	}
                                                       	
                                                        
                                                        
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar diligencia',
										width: 950,
										height:430,
										layout: 'fit',
										plain:true,
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
                                        			close: function(p)
                                                    		{
                                                    			
                                                    		},
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	 if(fDiligencia)
                                                                    {
                                                                        gEx('dteFechaDiligencia').setValue(fDiligencia.data.fechaDiligencia);
                                                                        cmbTipoDiligencia.setValue(fDiligencia.data.tipoDiligencia);
                                                                        dispararEventoSelectCombo('cmbTipoDiligencia');
                                                                        gEx('txtOtroTipoDiligencia').setValue(fDiligencia.data.otroTipoDiligencia);
                                                                        
                                                                        cmbParteProcesal.setValue(fDiligencia.data.idParteProcesal);
                                                                        
                                                                        //
                                                                        
                                                                        var pos=obtenerPosFila(cmbParteProcesal.getStore(),'id',cmbParteProcesal.getValue());
                                                                        var registro=cmbParteProcesal.getStore().getAt(pos);
                                                                        
                                                                        if(registro.data.valorComp.length>0)
                                                                        {
                                                                            
                                                                            cmbTipoParteProcesal.getStore().loadData(registro.data.valorComp);
                                                                            cmbTipoParteProcesal.show();
                                                                            cmbTipoParteProcesal.setValue(fDiligencia.data.idDetalleParteProcesal);
                                                                        }
                                                                        else
                                                                        {
                                                                            cmbTipoParteProcesal.setValue('');
                                                                            cmbTipoParteProcesal.hide();
                                                                        }
                                                                        
                                                                        pos=existeValorMatriz(arrParteProcesal,registro.data.id);
                                                                        if(arrParteProcesal[pos][3]!='')
                                                                        {
                                                                            function funcAjax()
                                                                            {
                                                                                var resp=peticion_http.responseText;
                                                                                arrResp=resp.split('|');
                                                                                if(arrResp[0]=='1')
                                                                                {
                                                                                    var arrDatos=eval(arrResp[1]);   
                                                                                    arrDatos.splice(arrDatos.length,0,['0','OTRO']);
                                                                                    gEx('txtNombre').setValue('');
                                                                                    gEx('txtNombre').hide();
                                                                                   
                                                                                    gEx('cmbNombre').show();
                                                                                    gEx('cmbNombre').getStore().loadData(arrDatos);
                                                                                    gEx('cmbNombre').setValue(fDiligencia.data.idNombreParteProcesal);
                                                                                    dispararEventoSelectCombo('cmbNombre');
                                                                                    gEx('txtNombre').setValue(fDiligencia.data.nombreParte);
                                                                                }
                                                                                else
                                                                                {
                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                }
                                                                            }
                                                                            obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=118&cA='+
                                                                                        gE('carpetaAdministrativa').value+'&fJ='+arrParteProcesal[pos][3],true);
                                                                
                                                                        }
                                                                        else
                                                                        {
                                                                            gEx('cmbNombre').setValue('');
                                                                            gEx('cmbNombre').hide();
                                                                            gEx('txtNombre').setPosition(140,70);
                                                                            gEx('txtNombre').show();
                                                                            gEx('txtNombre').setWidth(400);
                                                                            gEx('txtNombre').setValue(fDiligencia.data.nombreParte);
                                                                        }
                                                                        
                                                                        cmbOrden.setValue(fDiligencia.data.orden);
                                                                        //
                                                                        
                                                                        cmbResponsableDiligencia.setValue(fDiligencia.data.idResponsableDiligencia);
                                                                        dispararEventoSelectCombo('cmbResponsableDiligencia');
                                                                        gEx('txtResponsableDiligencia').setValue(fDiligencia.data.lblOtroResponsable);
                                                                        
                                                                        
                                                                        
                                                                        var registroMedio=crearRegistro	(
                                                                                                            [
                                                                                                                {name:'idMedio'},
                                                                                                                {name: 'detalle1'},
                                                                                                                {name:'detalle2'},
                                                                                                                {name: 'detalle3'},
                                                                                                                {name: 'resultado'},
                                                                                                                {name: 'citatorio'}
                                                                                                            ]
                                                                                                        )
                                                                        
                                                                        var x;
                                                                        for(x=0;x<fDiligencia.data.arrMediosNotificacion.length;x++)
                                                                        {
                                                                            var r=new registroMedio	(
                                                                                                        fDiligencia.data.arrMediosNotificacion[x]
                                                                                                    )
                                                                        
                                                                            gEx('gMedioNotificacion').getStore().add(r);
                                                                        }  
                                                                        
                                                                        
                                                                    }
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var dteFechaDiligencia=gEx('dteFechaDiligencia');
                                                                        if(dteFechaDiligencia.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	dteFechaDiligencia.focus();
                                                                            }
                                                                            msgBox('Debe indicar la fecha en que se llev&oacute;n acabo la diligencia',resp);
                                                                            gEx('panelDiligencia').setActiveTab(0);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(cmbTipoDiligencia.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbTipoDiligencia.focus();
                                                                            }
                                                                            msgBox('Debe indicar el tipo de diligencia llevada acabo',resp2);
                                                                            gEx('panelDiligencia').setActiveTab(0);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(cmbTipoDiligencia.getValue()=='0')
                                                                        {
                                                                        	if(gEx('txtOtroTipoDiligencia').getValue()=='')
                                                                            {
                                                                                function resp3()
                                                                                {
                                                                                    gEx('txtOtroTipoDiligencia').focus();
                                                                                }
                                                                                msgBox('Debe indicar el tipo de diligencia llevada acabo',resp3);
                                                                                gEx('panelDiligencia').setActiveTab(0);
                                                                                return;
                                                                            }
                                                                        }
                                                                        
                                                                        if(cmbParteProcesal.getValue()=='')
                                                                        {
                                                                        	function resp4()
                                                                            {
                                                                            	cmbParteProcesal.focus();
                                                                            }
                                                                            msgBox('Debe indicar la parte procesal sobre la cual recae la diligencia',resp4);
                                                                            gEx('panelDiligencia').setActiveTab(0);
                                                                            return;
                                                                        }
                                                                        
                                                                        if((cmbTipoParteProcesal.isVisible())&&(cmbTipoParteProcesal.getValue()==''))
                                                                        {
                                                                        	function resp5()
                                                                            {
                                                                            	cmbTipoParteProcesal.focus();
                                                                            }
                                                                            msgBox('Debe debe especificar el tipo de parte procesal',resp5);
                                                                            gEx('panelDiligencia').setActiveTab(0);
                                                                            return;
                                                                        }
                                                                        
                                                                        if((cmbNombre.isVisible())&&(cmbNombre.getValue()==''))
                                                                        {
                                                                        	function resp6()
                                                                            {
                                                                            	cmbNombre.focus();
                                                                            }
                                                                            msgBox('Debe indicar el nombre de la parte procesal',resp6);
                                                                            gEx('panelDiligencia').setActiveTab(0);
                                                                            return;
                                                                        }
                                                                        
                                                                        if((gEx('txtNombre').isVisible())&&(gEx('txtNombre').getValue()==''))
                                                                        {
                                                                        	function resp7()
                                                                            {
                                                                            	gEx('txtNombre').focus();
                                                                            }
                                                                            msgBox('Debe ingresar el nombre de la parte procesal',resp7);
                                                                            gEx('panelDiligencia').setActiveTab(0);
                                                                            return;
                                                                        }                                                                      
                                                                      
                                                                      	if(cmbResponsableDiligencia.getValue()=='')
                                                                        {
                                                                        	function resp8()
                                                                            {
                                                                            	cmbResponsableDiligencia.focus();
                                                                            }
                                                                            msgBox('Debe indicar al responsable de la diligencia',resp8);
                                                                            gEx('panelDiligencia').setActiveTab(0);
                                                                            return;
                                                                        }
                                                                        
                                                                        if((gEx('txtResponsableDiligencia').isVisible())&&(gEx('txtResponsableDiligencia').getValue()==''))
                                                                        {
                                                                        	function resp9()
                                                                            {
                                                                            	gEx('txtResponsableDiligencia').focus();
                                                                            }
                                                                            msgBox('Debe ingresar el nombre del responsable de la diligencia',resp9);
                                                                            gEx('panelDiligencia').setActiveTab(0);
                                                                            return;
                                                                        }                                                                        
                                                                        
                                                                        if(CKEDITOR.instances['txtExposicionDiligencia'].getData()=='')
                                                                        {
                                                                        	function resp10()
                                                                            {
                                                                            	CKEDITOR.instances['txtExposicionDiligencia'].focus();
                                                                            }
                                                                            msgBox('Debe ingresar la exposici&oacute;n de la diligencia',resp10);
                                                                            gEx('panelDiligencia').setActiveTab(1);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(gEx('gMedioNotificacion').getStore().getCount()==0)
                                                                        {
                                                                        	msgBox('Almenos debe ingresar un medio de notificaci&oacute;n');
                                                                           gEx('panelDiligencia').setActiveTab(0);
                                                                            return;
                                                                        }
                                                                        
                                                                        var idDiligencia=-1;
                                                                        if(fDiligencia)
                                                                        {
                                                                        	idDiligencia=fDiligencia.data.idDiligencia;
                                                                        }
                                                                        
                                                                        var arrMedioNotificacion='';
                                                                        var o='';
                                                                        var x;
                                                                        var fila;
                                                                       	for(x=0; x<gEx('gMedioNotificacion').getStore().getCount();x++)
                                                                        {
                                                                        	fila=gEx('gMedioNotificacion').getStore().getAt(x);
                                                                            
                                                                            o='{"idMedio":"'+fila.data.idMedio+'","detalle1":"'+fila.data.detalle1+'","detalle2":"'+
                                                                            	fila.data.detalle2+'","detalle3":"'+cv(fila.data.detalle3)+'","resultado":"'+fila.data.resultado+
                                                                                '","citatorio":"'+fila.data.citatorio+'"}';
                                                                            
                                                                            if(arrMedioNotificacion=='')
                                                                            	arrMedioNotificacion=o;
                                                                            else
                                                                            	arrMedioNotificacion+=','+o;
                                                                        }
                                                                        
                                                                        
                                                                        var objDiligencia='{"idActa":"'+gE('idActa').value+'","idDiligencia":"'+idDiligencia+'","fechaDiligencia":"'+dteFechaDiligencia.getValue().format('Y-m-d')+'","tipoDiligencia":"'+cmbTipoDiligencia.getValue()+
                                                                        				'","otroTipoDiligencia":"'+cv(gEx('txtOtroTipoDiligencia').getValue())+'","parteProcesal":"'+cmbParteProcesal.getValue()+
                                                                                        '","detalleParteProcesal":"'+cmbTipoParteProcesal.getValue()+'","idParteProcesal":"'+cmbNombre.getValue()+
                                                                                        '","nombreParteProcesal":"'+cv(gEx('txtNombre').getValue())+'","idResponsableDiligencia":"'+cmbResponsableDiligencia.getValue()+
                                                                                        '","nombreResponsableDiligencia":"'+cv(gEx('txtResponsableDiligencia').getValue())+'","exposicionDiligencia":"'+
                                                                                        cv(bE(CKEDITOR.instances['txtExposicionDiligencia'].getData()))+
                                                                                        '","arrMedioNotificacion":['+arrMedioNotificacion+'],"orden":"'+cmbOrden.getValue()+'"}';
                                                                        
																	
                                                                    	function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	gEx('gDiligencias').getStore().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=120&objDiligencia='+objDiligencia,true);
                                                                    
                                                                    
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
    
    var editor1=	CKEDITOR.replace('txtExposicionDiligencia',
                                                     {
                                                     	
                                                        customConfig:'../../modulosEspeciales_SGJP/Scripts/configCKEditorEjecucionV2.js',
                                                        height:210,
                                                        enterMode : CKEDITOR.ENTER_BR,
                                                        resize_enabled:false,
                                                        on:	{
                                                        		instanceReady:function(evt)
                                                                			{
                                                                            	if(fDiligencia)
	                                                                            	CKEDITOR.instances['txtExposicionDiligencia'].setData(escaparBR(fDiligencia.data.exposicionDiligencia,true));  
                                                                            }
                                                                
                                                        	}
                                                     }
                                    );
    
   	gEx('panelDiligencia').setActiveTab(0);
   
    
    
    
	                                   
}

function crearGridMedioNotificacion()
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idMedio'},
		                                                {name: 'detalle1'},
		                                                {name:'detalle2'},
		                                                {name: 'detalle3'},
                                                        {name: 'resultado'},
                                                        {name: 'citatorio'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                              reader: lector,
                                              proxy : new Ext.data.HttpProxy	(

                                                                                {

                                                                                    url: '../paginasFunciones/funcionesAlmacen.php'

                                                                                }

                                                                            ),
                                              sortInfo: {field: 'idMedio', direction: 'ASC'},
                                              groupField: 'idMedio',
                                              remoteGroup:false,
                                              remoteSort: false,
                                              autoLoad:false
                                              
                                          }) 
    alDatos.on('beforeload',function(proxy)
                          {
                              proxy.baseParams.funcion='87';
                              proxy.baseParams.idAlmacen=gE('idAlmacen').value;
                          }
              )   
    
    var cModelo= new Ext.grid.ColumnModel   	(
                                                  [
                                                      new  Ext.grid.RowNumberer(),
                                                      
                                                      {
                                                          header:'Medio de notificaci&oacute;n',
                                                          width:370,
                                                          sortable:true,
                                                          dataIndex:'idMedio',
                                                          renderer:function(val,meta,registro)
                                                          			{

                                                                    	var leyenda='';
                                                                        
                                                                        leyenda=formatearValorRenderer(aMediosNotificacionCatalogo,val);
                                                                        if(registro.data.detalle1!='')
                                                                        {
                                                                        	leyenda+=' - ';
                                                                            leyenda+=formatearValorRenderer(aMediosNotificacionDetalle2,registro.data.detalle1);
                                                                        }
                                                                        
                                                                        if(registro.data.detalle2!='')
                                                                        {
                                                                        	leyenda+=' - ';
                                                                            leyenda+=formatearValorRenderer(aMediosNotificacionDetalle2,registro.data.detalle2);
                                                                        }
                                                                        
                                                                        if(registro.data.detalle3!='')
                                                                        {
                                                                        	leyenda+=': ';
                                                                            leyenda+=registro.data.detalle3;
                                                                        }
                                                                        
                                                                        return leyenda;
                                                                    }
                                                      },
                                                      {
                                                          header:'Resultado',
                                                          width:300,
                                                          sortable:true,
                                                          dataIndex:'resultado',
                                                          renderer:function(val,meta,registro)
                                                          		{
                                                                	var leyenda=formatearValorRenderer(arrResultadoDiligenciasMP,val,1,true);
                                                                    switch(registro.data.citatorio)
                                                                    {
                                                                    	case '1':
                                                                        	leyenda+=' (Se dej&oacute; citatorio de segunda visita)'
                                                                        break;
                                                                    }
                                                                    
                                                                    
                                                                	return mostrarValorDescripcion(leyenda);
                                                                }
                                                      }
                                                  ]
                                              );
                                          
    var tblGrid=	new Ext.grid.GridPanel	(
                                                  {
                                                      id:'gMedioNotificacion',
                                                      store:alDatos,
                                                      x:180,
                                                      y:130,
                                                      frame:false,
                                                      height:150,
                                                      width:720,
                                                      cm: cModelo,
                                                      stripeRows :true,
                                                      loadMask:true,
                                                      columnLines : true,
                                                      tbar:	[
                                                      			{
                                                                    icon:'../images/add.png',
                                                                    cls:'x-btn-text-icon',
                                                                    text:'Agregar medio de notificaci&oacute;n',
                                                                    handler:function()
                                                                            {
                                                                                mostrarVentanaAgregarMedioNotificacion();
                                                                            }
                                                                    
                                                                },'-',
                                                                {
                                                                    icon:'../images/delete.png',
                                                                    cls:'x-btn-text-icon',
                                                                    text:'Remover medio de notificaci&oacute;n',
                                                                    handler:function()
                                                                            {
                                                                                var fila=gEx('gMedioNotificacion').getSelectionModel().getSelected();
                                                                                if(!fila)
                                                                                {
                                                                                	msgBox('Debe seleccionar el medio de notificaci&oacute;n que desea remover');
                                                                                    return;
                                                                                }
                                                                                
                                                                                function resp(btn)
                                                                                {
                                                                                	if(btn=='yes')
                                                                                    {
                                                                                    	removerMedioNotificacion(CKEDITOR.instances['txtExposicionDiligencia'],fila);
                                                                                		gEx('gMedioNotificacion').getStore().remove(fila);
                                                                                    }
                                                                                }
                                                                                msgConfirm('Est&aacute; seguro de querer remover el medio de notificaci&oacute;n seleccionado?',resp);
                                                                                
                                                                            }
                                                                    
                                                                }
                                                      		],
                                                      view:new Ext.grid.GroupingView({
                                                                                          forceFit:false,
                                                                                          showGroupName: false,
                                                                                          enableGrouping :false,
                                                                                          enableNoGroups:false,
                                                                                          enableGroupingMenu:false,
                                                                                          hideGroupedColumn: false,
                                                                                          startCollapsed:false
                                                                                      })
                                                  }
                                                  );
    return 	tblGrid;
}

function mostrarVentanaAgregarMedioNotificacion()
{
	if(gEx('cmbTipoDiligencia').getValue()=='')
    {
    	function resp1()
        {
        	gEx('cmbTipoDiligencia').focus();
        }
    	msgBox('Primero debe indicar el tipo de diligencia',resp1)
    	return;
    }
    
    if(gEx('cmbParteProcesal').getValue()=='')
    {
    	function resp3()
        {
        	gEx('cmbParteProcesal').focus();
        }
    	msgBox('Primero debe indicar la parte procesal a notificar',resp3)
    	return;
    }
    
	var cmbMedioNotificacion=crearComboExt('cmbMedioNotificacion',[],160,5,350);
    cmbMedioNotificacion.on('select',function(cmb,registro)
    								{
                                   		gEx('cmbResultadoNotificacion').getStore().loadData(arrResultadoDiligencias);
                                    	gEx('lblCitatorio').hide();
                                        gEx('cmbCitatorio').hide();
                                        gEx('cmbCitatorio').setValue('');
                                    	cmbDetalles.getStore().removeAll();
                                        cmbDetalles.setValue('');
                                        cmbDetalles.disable();
                                        cmbDetalles2.getStore().removeAll();
                                        cmbDetalles2.setValue('');
                                        cmbDetalles2.disable();
                                        gEx('txtDetalles2').setValue('');
                                    	gEx('txtDetalles2').hide();
                                    	if(registro.data.valorComp.length>0)
                                        {
                                        	cmbDetalles.getStore().loadData(registro.data.valorComp);
                                         	cmbDetalles.enable();   
                                        }
                                        
                                        if(registro.data.id=='1')
                                		{
                                        	gEx('lblCitatorio').show();
                                        	gEx('cmbCitatorio').show();
                                        }
                                    }
    						)
    var cmbDetalles=crearComboExt('cmbDetalles',[],160,35,250);
    cmbDetalles.disable();
    
    cmbDetalles.on('select',function(cmb,registro)
    						{
                           		
                            	cmbDetalles2.getStore().removeAll();
                                cmbDetalles2.setValue('');
                                cmbDetalles2.disable();
                                gEx('txtDetalles2').setValue('');
                                gEx('txtDetalles2').hide();
                                if(registro.data.valorComp.length>0)
                                {
                                    cmbDetalles2.getStore().loadData(registro.data.valorComp);
                                    cmbDetalles2.enable();   
                                }
                                gEx('txtDetalles2').setPosition(420,65);
                                if(registro.data.id=='0')
                                {
                                	gEx('txtDetalles2').setPosition(420,35);
                                	gEx('txtDetalles2').show();
                                    gEx('txtDetalles2').focus(false,500);
                                }
                                gEx('cmbResultadoNotificacion').getStore().loadData(arrResultadoDiligencias);
                                 
                                if(registro.data.id=='8')
                                {
                                    gEx('lblCitatorio').show();
                                    gEx('cmbCitatorio').show();
                                    if(gEx('cmbParteProcesal').getValue()=='1')
                                    	gEx('cmbResultadoNotificacion').getStore().loadData(arrResultadoDiligenciasMP);
                                }
                                else
                                {
                                	gEx('lblCitatorio').hide();
                                    gEx('cmbCitatorio').hide();
                                    gEx('cmbCitatorio').setValue('');
                                   
                                }
                            }
    				)
    
    var cmbDetalles2=crearComboExt('cmbDetalles2',[],160,65,250);
    cmbDetalles2.on('select',function(cmb,registro)
    						{
                            	if(registro.data.id=='0')
                                {
                                    
                                    gEx('txtDetalles2').show();
                                    gEx('txtDetalles2').focus(false,500);
								}
                                else
                                {
                                	gEx('txtDetalles2').setValue('');
                                    gEx('txtDetalles2').hide();
                                }                                
                               
                            }
    				)
    cmbDetalles2.disable();
    
    
    var cmbResultadoNotificacion=crearComboExt('cmbResultadoNotificacion',arrResultadoDiligencias,200,95,380);
    
    cmbResultadoNotificacion.on('select',function(cmb,registro)		
   											{
   												if((registro.data.id=='1.5')||(registro.data.id=='3'))
   												{
   													gEx('cmbCitatorio').setValue('1');
   													gEx('cmbCitatorio').disable();
   												}
   												else
   												{
   													gEx('cmbCitatorio').setValue('');
   													gEx('cmbCitatorio').enable();
   												}
   											}
    							)
    
    var cmbCitatorio=crearComboExt('cmbCitatorio',arrSiNo,200,125,150);
    cmbCitatorio.hide();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	xytpe:'label',
                                                            html:'Medio de notificaci&oacute;n:',
                                                            x:10,
                                                            y:10
                                                        },
                                                        cmbMedioNotificacion,
                                                        {
                                                        	xytpe:'label',
                                                            html:'Detalles/especificaci&oacute;n:',
                                                            x:10,
                                                            y:40
                                                        },
                                                        cmbDetalles,
                                                        cmbDetalles2,
                                                        {
                                                        	xtype:'textfield',
                                                            x:420,
                                                            y:65,
                                                            width:170,
                                                            hidden:true,
                                                            id:'txtDetalles2'
                                                        },
                                                        {
                                                        	xytpe:'label',
                                                            html:'Resultado de la notificaci&oacute;n:',
                                                            x:10,
                                                            y:100
                                                        },
                                                        cmbResultadoNotificacion,
                                                        {
                                                        	xytpe:'label',
                                                            html:'Se dej&oacute; citario de seguda visita?:',
                                                            x:10,
                                                            id:'lblCitatorio',
                                                            hidden:true,
                                                            y:130
                                                        },
                                                        cmbCitatorio
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar medio de notificaci&oacute;n',
										width: 620,
										height:240,
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
                                                                    	var medioNotificacion='';
                                                                        var lblDetalle1='';
                                                                        var lblDetalle2='';
                                                                        var resultadoNotificacion='';
                                                                        var seDejoCitatorio='';
                                                                        var txtDetalles2='';
                                                                        
																		if(cmbMedioNotificacion.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbMedioNotificacion.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el medio de notificaci&oacute;n',resp);
                                                                            return;
                                                                            
                                                                            
                                                                        }
                                                                        medioNotificacion=cmbMedioNotificacion.getValue();
                                                                        if(!cmbDetalles.disabled)
                                                                        {
                                                                        	if(cmbDetalles.getValue()=='')
                                                                            {
                                                                                function resp2()
                                                                                {
                                                                                    cmbDetalles.focus();
                                                                                }
                                                                                msgBox('Debe indicar el detalle sobre el medio de notificaci&oacute;n',resp2);
                                                                                return;
                                                                           }
                                                                           
                                                                           if((cmbDetalles.getValue()=='0')&&(gEx('txtDetalles2').getValue()==''))
                                                                           {
                                                                           		function resp4()
                                                                                {
                                                                                    gEx('txtDetalles2').focus();
                                                                                }
                                                                                msgBox('Debe especificar el detalle sobre el medio de notificaci&oacute;n',resp4);
                                                                                return;
                                                                           }
                                                                           
                                                                           lblDetalle1=cmbDetalles.getValue();
                                                                           
                                                                        }
                                                                        
                                                                        if(!cmbDetalles2.disabled)
                                                                        {
                                                                        	if(cmbDetalles2.getValue()=='')
                                                                            {
                                                                                function resp3()
                                                                                {
                                                                                    cmbDetalles2.focus();
                                                                                }
                                                                                msgBox('Debe indicar el detalle sobre el medio de notificaci&oacute;n',resp3);
                                                                                return;
                                                                                
																			}  
                                                                            
                                                                            if((cmbDetalles2.getValue()=='0')&&(gEx('txtDetalles2').getValue()==''))
                                                                           	{
                                                                           		function resp5()
                                                                                {
                                                                                    gEx('txtDetalles2').focus();
                                                                                }
                                                                                msgBox('Debe especificar el detalle sobre el medio de notificaci&oacute;n',resp5);
                                                                                return;
                                                                           }   
                                                                           
                                                                           	lblDetalle2= cmbDetalles2.getValue();                                                                      
                                                                            
                                                                        }                                                                                                                                               
                                                                        
                                                                        if(cmbResultadoNotificacion.getValue()=='')
                                                                        {
                                                                        	function resp5()
                                                                            {
                                                                            	cmbResultadoNotificacion.focus();
                                                                            }
                                                                            msgBox('Debe indicar el resultado de la notificaci&oacute;n',resp5);
                                                                            return;
                                                                            
                                                                        }
                                                                        resultadoNotificacion=cmbResultadoNotificacion.getValue();
                                                                        
                                                                        txtDetalles2=gEx('txtDetalles2').getValue();
                                                                        
                                                                        if(cmbCitatorio.isVisible())
                                                                        {
                                                                        	if(cmbCitatorio.getValue()=='')
                                                                            {
                                                                            	function resp6()
                                                                                {
                                                                                	cmbCitatorio.focus();
                                                                                }
                                                                                msgBox('Debe ingresar si dej&oacute;n citatorio como resultado de la diligencia',resp6);
                                                                            	return;
                                                                            }
                                                                        	seDejoCitatorio=cmbCitatorio.getValue();
                                                                        }
                                                                        
                                                                        var registro=crearRegistro	(
                                                                        								[
                                                                                                        	{name:'idMedio'},
                                                                                                            {name: 'detalle1'},
                                                                                                            {name:'detalle2'},
                                                                                                            {name: 'detalle3'},
                                                                                                            {name: 'resultado'},
                                                                                                            {name: 'citatorio'}
                                                                                                        ]
                                                                        							)
                                                                        var r=new registro	(
                                                                        						{
                                                                                                	idMedio:medioNotificacion,
                                                                                                    detalle1:lblDetalle1,
                                                                                                    detalle2:lblDetalle2,
                                                                                                    detalle3:txtDetalles2,
                                                                                                    resultado:resultadoNotificacion,
                                                                                                    citatorio:seDejoCitatorio
                                                                                                }
                                                                        					)
																	
                                                                    	gEx('gMedioNotificacion').getStore().add(r);
                                                                        formatearExposicionDiligencia(r);
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

	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	aMedioNotificacion=eval(arrResp[1]);
            gEx('cmbMedioNotificacion').getStore().loadData(aMedioNotificacion);
            ventanaAM.show();	
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=119&tD='+
    gEx('cmbTipoDiligencia').getValue()+'&pp='+gEx('cmbParteProcesal').getValue(),true);

	
}

function formatearFilaDiligencia(registro, numFila, rp, ds)
{
	var lblResponsableDiligencia=formatearValorRenderer(arrResponsableDiligencia,registro.data.idResponsableDiligencia);
    if(parseInt(registro.data.idResponsableDiligencia)==0)
    {
    	lblResponsableDiligencia+=': '+registro.data.lblOtroResponsable;
    }
    
    var tblMedioNotificacion='';
    var x;
    var fila;
    var leyenda='';
    var leyendaResultado='';
    tblMedioNotificacion='<table width="800">';
    
    for(x=0;x<registro.data.arrMediosNotificacion.length;x++)
    {
    	fila=registro.data.arrMediosNotificacion[x];   
                                                                     
        leyenda=formatearValorRenderer(aMediosNotificacionCatalogo,fila.idMedio);
        if(fila.detalle1!='')
        {
            leyenda+=' - ';
            leyenda+=formatearValorRenderer(aMediosNotificacionDetalle2,fila.detalle1);
        }
        
        if(fila.detalle2!='')
        {
            leyenda+=' - ';
            leyenda+=formatearValorRenderer(aMediosNotificacionDetalle2,fila.detalle2);
        }
        
        if(fila.detalle3!='')
        {
            leyenda+=': ';
            leyenda+=fila.detalle3;
        }
        
        leyendaResultado=formatearValorRenderer(arrResultadoDiligenciasMP,fila.resultado,1,true);
        switch(fila.citatorio)
        {
            case '1':
                leyendaResultado+=' - Se dej&oacute; citatorio de segunda visita';
            break;
        }
       	tblMedioNotificacion+='<tr height="21"><td><span class="TSJDF_Control">'+leyenda+' (<b>Resultado:</b> '+leyendaResultado+')</span></td></tr>';
        
        
        
    }
    tblMedioNotificacion+='</table>';
	var lblTable='<br><table width="100%">'+
    			'<tr height="21"><td width="40"></td><td width="150"><span class="TSJDF_Etiqueta">Responsable de la diligencia:</span></td>'+
                '<td width="750"><span class="TSJDF_Control">'+lblResponsableDiligencia+'</span></td></tr>'+
                '<tr height="21"><td ></td><td colspan="1"><span class="TSJDF_Etiqueta">Medios de notificaci&oacute;n:</span></td><td>'+tblMedioNotificacion+'</td></tr>'+
    			'<tr height="21"><td ></td><td colspan="2"><span class="TSJDF_Etiqueta">Exposici&oacute;n diligencia:</span></td></tr>'+
    			'<tr height="21"><td></td><td style="text-align:justify" colspan="2"><span class="TSJDF_Control">'+registro.data.exposicionDiligencia+'</span></td></tr>'+
                '</table><br>';
    rp.body=lblTable;	
    return 'x-grid3-row-expanded';
    
    
}

function functionAfterSignDocument(ventana)
{
	if(gEx('vCDocument'))
		gEx('vCDocument').close();
    establecerSoloLectura();    
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            visualizarActaCircunstanciada();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=130&iA='+gE('idActa').value,true);
    
    
    
}

function establecerSoloLectura()
{
	gEx('btnViewActa').show();
	gEx('btnAddDiligencia').hide();
    gEx('btnModifyDiligencia').hide();
    gEx('btnDelDiligencia').hide();
    gEx('btnSaveActa').hide();
	gEx('btnBuildActa').hide();  
    gEx('dteFechaActa').disable();
    gEx('cmbTipoActa').disable();
    gEx('txtNombreDeterminacion').disable();
    gEx('cmbAudienciaDeriva').disable();
    gEx('dteFechaDterminacion').disable();
    gEx('txtComentarios').setReadOnly(true);
    
}

function visualizarActaCircunstanciada()
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrNombre=arrResp[2].split('.');
            extension=arrNombre[arrNombre.length-1];
            mostrarVisorDocumentoProceso(extension,arrResp[1]);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=131&tD=214&iF=-1&iR='+gE('idActa').value,true);
}

function formatearExposicionDiligencia(f)
{

	var cadObj='{"idActa":"'+gE('idActa').value+'","tipoDiligencia":"'+gEx('cmbTipoDiligencia').getValue()+'","fecha":"'+gEx('dteFechaDterminacion').getValue().format('Y-m-d')+'","fechaDiligencia":"'+gEx('dteFechaDiligencia').getValue().format('Y-m-d')+
			'","parteProcesal":"'+gEx('cmbParteProcesal').getValue()+'","detalleParteProcesal":"'+gEx('cmbTipoParteProcesal').getValue()+
			'","nombreParte":"'+cv(gEx('txtNombre').isVisible()?gEx('txtNombre').getValue().trim():gEx('cmbNombre').getRawValue())+'","idMedio":"'+f.data.idMedio+'","detalle1":"'+f.data.detalle1+
			'","detalle2":"'+f.data.detalle2+'","detalle3":"'+f.data.detalle3+
			'","resultado":"'+f.data.resultado+'","citatorio":"'+f.data.citatorio+'"}';
	
	function funcAjax()
	{
		var resp=peticion_http.responseText;
		arrResp=resp.split('|');
		if(arrResp[0]=='1')
		{
			var obj=eval('['+arrResp[1]+']')[0];
			if(bD(obj.exposicionDiligencia)!='')
			{
				gEx('panelDiligencia').setActiveTab('exposicion');
				setLastCursor(CKEDITOR.instances['txtExposicionDiligencia']);
				var container =CKEDITOR.dom.element.createFromHtml('<marcadorTexto_'+f.data.idMedio+'_'+f.data.detalle1+
						'_'+f.data.detalle2+'_'+f.data.detalle3.replace(/\b/gi,'_')+'>'+bD(obj.exposicionDiligencia), CKEDITOR.instances['txtExposicionDiligencia'].document);
				CKEDITOR.instances['txtExposicionDiligencia'].insertElement(container);
				gEx('panelDiligencia').setActiveTab('dGenerales');
			}
		}
		else
		{
			msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
		}
	}
	obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=157&cadObj='+cadObj,true);
}

function setLastCursor(oEditor)
{
	
	oEditor.focus();

	var s = oEditor.getSelection(); // getting selection
	var selected_ranges = s.getRanges(); // getting ranges
	var node = selected_ranges[0].startContainer; // selecting the starting node
	var parents = node.getParents(true);

	node = parents[parents.length - 2].getFirst();

	while (true) 
	{
		var x = node.getNext();
		if (x == null) {
			break;
		}
		node = x;
	}

	s.selectElement(node);
	selected_ranges = s.getRanges();
	selected_ranges[0].collapse(false);  
	s.selectRanges(selected_ranges); 
}

function removerMedioNotificacion(oEditor,f)
{
	
	var tag='<marcadorTexto_'+f.data.idMedio+'_'+f.data.detalle1+'_'+f.data.detalle2+'_'+f.data.detalle3.replace(/\b/gi,'_')+'>';
	tag=tag.toLowerCase();
	
	var contenido=oEditor.getData();
	var arrContenido=contenido.split('<br />\n'+tag);//
	if(arrContenido.length==1)
		arrContenido=contenido.split(tag);
	var contenido=arrContenido[0];
	if(arrContenido.length>1)
	{
		tag=tag.replace('<','</');
		arrContenido=arrContenido[1].split(tag);
		if(arrContenido.length>1)
			contenido+=arrContenido[1];
		else
			contenido+=arrContenido[0];
		
	}
	oEditor.setData(contenido);
	
	
}
