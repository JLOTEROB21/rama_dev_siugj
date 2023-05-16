<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$consulta="SELECT idSituacion,icono,tamano FROM 7011_situacionEventosAudiencia";
	$arrSituaciones=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__4_tablaDinamica,tipoAudiencia FROM _4_tablaDinamica ORDER BY tipoAudiencia";
	$arrTiposAudiencia=$con->obtenerFilasArreglo($consulta);
	
	
	
	$arrTiposRecurso="[]";
	$consulta="SELECT idFormulario FROM 900_formularios WHERE categoriaFormulario=10";
	$idFormularioAux=$con->obtenerValor($consulta);
	if($idFormularioAux!="")
	{
		$consulta="SELECT id__".$idFormularioAux."_tablaDinamica,tipoRecurso FROM _".$idFormularioAux."_tablaDinamica";
		$arrTiposRecurso=$con->obtenerFilasArreglo($consulta);
	}
	
	$arrRecursos="[]";
	$consulta="SELECT idFormulario FROM 900_formularios WHERE categoriaFormulario=11";
	$idFormularioAux=$con->obtenerValor($consulta);
	if($idFormularioAux!="")
	{
		$consulta="SELECT id__".$idFormularioAux."_tablaDinamica,nombreRecurso FROM _".$idFormularioAux."_tablaDinamica";
		$arrRecursos=$con->obtenerFilasArreglo($consulta);
	}
	
?>
var arrHoras;
var fechaInicioAudienciaAux;
var fechaFinAudienciaAux;
var idRegistroRecursoIng=-1;
var arrRecursosRemovidos=[];
var regRecursosAdiconales;

var lblDuracionRecursoAudiencia=60;
var arrRecursos=<?php echo $arrRecursos?>;
var arrTiposRecurso=<?php echo $arrTiposRecurso?>;

var tipoMateria='<?php echo $tipoMateria ?>';
var arrTiposAudiencia=<?php echo $arrTiposAudiencia?>;
var arrSemaforo=<?php echo $arrSituaciones?>;
var arrSituaciones=<?php echo $arrSituaciones?>;
var idEventoAudiencia=-1;
var objDatosAudiencia=null;
var objConfiguracionTablero=null;

function construirTableroEvento(objConfRenderer)
{
	 var horaInicial=new Date(2010,5,10,7,0);
	var horaFinal=new Date(2010,5,10,23,59);
    
	arrHoras=generarIntervaloHoras(horaInicial,horaFinal,1,'H:i','H:i');
	objConfiguracionTablero=objConfRenderer;
	idEventoAudiencia=objConfRenderer.idEvento;
	if(objConfRenderer.permiteModificarJuez||objConfRenderer.permiteModificarEdificio || objConfRenderer.permiteModificarUnidadGestion || objConfRenderer.permiteModificarSala || objConfRenderer.permiteModificarFecha)
    {
    	if(!window.CKEDITOR)
        {
        	loadScript('../modulosEspeciales_SGJP/Scripts/controlAgenda.js.php', function()
                                                        {
                                                            
                                                        }
                        );
        
            loadScript('../Scripts/fullcalendar/lib/moment.min.js', function()
                                                        {
                                                            
                                                        }
                        );
           
           	          
           
           	                  
            
           
                        
		}  
        
        if(!existeFuncionJS('Base64'))
        {
                          
            loadScript('../Scripts/base64.js', function()
                                                        {
                                                            
                                                        }
                        );                    
		}                    
    }

	if(typeof(obtenerDatosWebV2)=='undefined')
    {
        loadScript('../Scripts/funcionesAjaxV2.js', function()
                                                    {
                                                    	consultarDatosEvento(objConfRenderer);
                                                    }
                    );
	}
    else
    {
    	consultarDatosEvento(objConfRenderer);
    }
}

function consultarDatosEvento(objConfRenderer)
{
	gE(objConfiguracionTablero.renderTo).innerHTML='';
	function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        
            var objConf=eval('['+arrResp[1]+']')[0];
            objDatosAudiencia=objConf;

            var tblDestino=gE(objConfiguracionTablero.renderTo);
            var duracionEstimada='(Informaci&oacute;n no disponible)';
            var lblHorario='(Informaci&oacute;n no disponible)';
            var lblHorarioInicial=lblHorario;
            var fechaEvento='(Informaci&oacute;n no disponible)';
            if(objConf.horaInicio!='')
            {
            	fechaEvento=convertirFechaToLetra(objConf.fechaEvento,true);
                var fechaHoraInicio=Date.parseDate(objConf.horaInicio,'Y-m-d H:i:s');
                var fechaHoraFin=Date.parseDate(objConf.horaFin,'Y-m-d H:i:s');
                var comp='';
                if(fechaHoraInicio.format('Y-m-d')!=fechaHoraFin.format('Y-m-d'))
                {
                    comp=' del '+convertirFechaToLetra(fechaHoraInicio.format('Y-m-d'),true);
                }
                
                
                duracionEstimada=((fechaHoraFin-fechaHoraInicio+0)/60000)+' minutos';
                lblHorarioInicial=fechaHoraInicio.format('H:i')+' hrs.';
                lblHorario='De las '+fechaHoraInicio.format('H:i')+' hrs.'+comp+' a las '+fechaHoraFin.format('H:i')+' hrs. del '+convertirFechaToLetra(fechaHoraFin.format('Y-m-d'),true);
			}       
                 
            var duracionReal='(Informaci&oacute;n no reportada)';
            var lblHorarioReal='(Informaci&oacute;n no reportada)';
            if(objConf.horaInicioReal!='')
            {
            
                var fechaHoraInicioReal=Date.parseDate(objConf.horaInicioReal,'Y-m-d H:i:s');
                var fechaHoraFinReal=Date.parseDate(objConf.horaFinReal,'Y-m-d H:i:s');
                var comp='';
                if(fechaHoraInicioReal.format('Y-m-d')!=fechaHoraFinReal.format('Y-m-d'))
                {
                    comp=' del '+convertirFechaToLetra(fechaHoraInicioReal.format('Y-m-d'),true);
                }
                
                
                duracionReal=((fechaHoraFinReal-fechaHoraInicioReal+0)/60000)+' minutos';
                lblHorarioReal='De las '+fechaHoraInicioReal.format('H:i')+' hrs.'+comp+' a las '+fechaHoraFinReal.format('H:i')+' hrs. del '+convertirFechaToLetra(fechaHoraFinReal.format('Y-m-d'),true);
               
            } 
            
            /*if(objConf.situacion!='0')
            {
            	objConfRenderer.permiteModificarJuez=false;
            }*/
            
            var lblJueces='';            
            var x;
            for(x=0;x<objConf.jueces.length;x++)
            {
            	if(tipoMateria=='SCC')
                	lblJueces+=objConf.jueces[x].nombreJuez+(objConfRenderer.permiteModificarJuez?'&nbsp;&nbsp;<a href="javascript:mostrarModificacionJuez(\''+bE(objConf.jueces[x].idRegistroEventoJuez)+'\')"><span style="font-size:9px">Modificar</span></a>':'')+'<br>';
                else
            		lblJueces+=objConf.jueces[x].nombreJuez+' ('+objConf.jueces[x].titulo+')'+(objConfRenderer.permiteModificarJuez?'&nbsp;&nbsp;<a href="javascript:mostrarModificacionJuez(\''+bE(objConf.jueces[x].idRegistroEventoJuez)+'\')"><span style="font-size:9px">Modificar</span></a>':'')+'<br>';
            }
            
            var lblAciones='';
            
            /*if(objConfRenderer.permiteModificarEdificio || objConfRenderer.permiteModificarUnidadGestion)
            {
            	lblAciones+='<td><span id="btnModificacionUG"></span></td><td width="5"></td>';
            }*/
            
            if(objConfRenderer.permiteModificarSala || objConfRenderer.permiteModificarFecha )
            {
            	lblAciones+='<td align="left"><span id="btnCancelarAudiencia"></span></td><td align="left"><span id="btnResolverAcuerdo"></span></td><td align="left"><span id="btnModificacionSala"></span></td>';
            }

			if(lblAciones!='')
            {
            	lblAciones='<br><table><tr>'+lblAciones+'</tr></table><br>';
            }
            else
            	lblAciones='';           

            
            var tabla='	<table width="800px">';
            
            tabla+='	<tr height="23"><td align="left" colspan="8" ><br><span class="SeparadorSeccion" style="width:750px">Datos de la audiencia</span><br></td></tr>';
            
            
            if(objConfRenderer.mostrarIDEvento)
	            tabla+='	<tr height="23"><td align="left"><span class="TSJDF_Etiqueta">ID Evento:</span></td><td colspan="3" align="left"><span class="TSJDF_Control">'+objConf.idEvento+'</span></td></tr>';
           
           	if(objConfRenderer.mostrarCarpetaAsociada)
            {
            	var lblApertura='';
                if(objConfRenderer.permiteAperturaCarpetaAsociada)
                	lblApertura='[&nbsp;<span style="font-size:11px"><a href="javascript:abrirCarpetaJudicial()"><img src="../images/magnifier.png"> Abrir '+(tipoMateria=='P'?(objConf.tipoCarpeta=='8'?'Carpeta Judicial de Alzada':'Carpeta Judicial'):'No. Expediente')+'</a></span>&nbsp;]';
	            tabla+='	<tr height="23"><td align="left"><span class="TSJDF_Etiqueta">'+(tipoMateria=='P'?(objConf.tipoCarpeta=='8'?'Carpeta Judicial de Alzada':'Carpeta Judicial'):'No. Expediente')+':</span></td><td colspan="3" align="left"><span class="TSJDF_Control">'+objConf.carpetaJudicial+' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+lblApertura+'</span></td></tr>';
            }
            if(objConfRenderer.mostrarFechaAudiencia)
            {
            	var btnInfoSituacion='';
                if((objConf.iRegistroSituacion!='-1')&&(objConfRenderer.mostrarInfoSituacion))
                {
                	btnInfoSituacion='&nbsp;&nbsp;<a href="javascript:abrirFormatoRegistro(\''+bE(objConf.iFormularioSituacion)+'\',\''+bE(objConf.iRegistroSituacion)+'\')"><img src="../images/magnifier.png"></a>';
                }
	            tabla+='	<tr height="23"><td align="left"><span class="TSJDF_Etiqueta">Fecha de la audiencia:</span></td><td colspan="3" align="left"><span class="TSJDF_Control">'+fechaEvento+' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[<span style=""><b>Situaci&oacute;n:</b> '+objConf.lblSituacion+btnInfoSituacion+'</span>]</span></td></tr>';
            }
            
            if(objConfRenderer.mostrarFechaAudiencia)
            {
            	if(objConfRenderer.mostrarSoloHoraInicial)
                	tabla+='	<tr height="23"><td align="left"><span class="TSJDF_Etiqueta">Horario:</span></td><td colspan="3" align="left"><span class="TSJDF_Control">'+lblHorarioInicial+'</span></td></tr>';
                else
            		tabla+='	<tr height="23"><td align="left"><span class="TSJDF_Etiqueta">Horario:</span></td><td colspan="3" align="left"><span class="TSJDF_Control">'+lblHorario+'</span></td></tr>';
            }
            
            if(objConfRenderer.mostrarTipoAudiencia)
            {
            	if(objConfRenderer.permiteModificarTipoAudiencia)
                {
                	
                	tabla+='	<tr height="23"><td align="left"><span class="TSJDF_Etiqueta">Tipo de audiencia:</span></td><td colspan="3" align="left"><select id="cmbTipoAudicia" class="TSJDF_Control" style="width:400px" onchange="cmbTipoAudienciaChange(this)"></select></td></tr>';
                }
                else
                {
            		tabla+='	<tr height="23"><td align="left"><span class="TSJDF_Etiqueta">Tipo de audiencia:</span></td><td colspan="3" align="left"><span class="TSJDF_Control">'+objConf.tipoAudiencia+'</span></td></tr>';
	            }
            }
            
            if(objConfRenderer.mostrarDuracionAudiencia)
            {
            	tabla+='	<tr height="23"><td align="left"><span class="TSJDF_Etiqueta">Duraci&oacute;n estimada:</span></td><td colspan="3" align="left"><span class="TSJDF_Control">'+duracionEstimada+'</span></td></tr>';
            }
            
            if(objConfRenderer.mostrarSalaAudiencia)
            {
            	tabla+='	<tr height="23"><td align="left"><span class="TSJDF_Etiqueta">Sala asignada:</span></td><td colspan="3" align="left"><span class="TSJDF_Control">'+objConf.sala+'</span></td></tr>';
            }
            
            if(objConfRenderer.mostrarSecretariaAudiencia)
            {
            	tabla+='	<tr height="23"><td align="left"><span class="TSJDF_Etiqueta">Secretar&iacute;a:</span></td><td colspan="3" align="left"><span class="TSJDF_Control">'+objConf.sala+'</span></td></tr>';
            }
            
            if(objConfRenderer.mostrarCentroGestion)
            {
            	tabla+='	<tr height="23"><td align="left"><span class="TSJDF_Etiqueta">'+(tipoMateria=='P'?(objConf.tipoCarpeta=='8'?'Tribunal':'Centro de Gesti&oacute;n'):(tipoMateria=='SCC'?'Sala Constitucional':'Juzgado'))+':</span></td><td colspan="3" align="left"><span class="TSJDF_Control">'+objConf.unidadGestion+'</span></td></tr>';
            }
            if(objConfRenderer.mostrarEdificio)
            {
            	tabla+='	<tr height="23"><td align="left"><span class="TSJDF_Etiqueta">Edificio sede:</span></td><td colspan="3" align="left"><span class="TSJDF_Control">'+objConf.edificio+'</span></td></tr>';
            }
            if(objConfRenderer.mostrarJueces)
            {
            	if((objConf.tipoCarpeta=='8')||(tipoMateria=='SCC'))
                	tabla+='	<tr height="23"><td align="left" style="vertical-align:top; padding-top:4px"><span class="TSJDF_Etiqueta">'+((objConf.jueces.length==1)?'Magistrado asignado:':'Magistrados asignados:')+'</span></td><td colspan="3" align="left"><span class="TSJDF_Control">'+lblJueces+'</span></td></tr>';
               	else
            		tabla+='	<tr height="23"><td align="left" style="vertical-align:top; padding-top:4px"><span class="TSJDF_Etiqueta">'+((objConf.jueces.length==1)?'Juez asignado:':'Jueces asignados:')+'</span></td><td colspan="3" align="left"><span class="TSJDF_Control">'+lblJueces+'</span></td></tr>';
            }
            if(lblAciones!='')
            {
            	tabla+='	<tr style="display:none"><td  align="right"  colspan="4"><span class="TSJDF_Control">'+lblAciones+'</span></td></tr>';
            }         
			
            if(objConfRenderer.mostrarAsignacionAuxiliar)
            {
  				          
            	tabla+='	<tr height="23"><td align="left"><span class="TSJDF_Etiqueta">Auxiliar de sala asignado:</span></td><td colspan="3" align="left"><table><tr><td><span class="TSJDF_Control" id="spNombreAuxiliar">'+
                		(gE('sL').value=='1'?objConf.lblNombreAuxiliarSala:'')+'</span></td><td width="15"></td><td><span id="tblAsignar"></span></td></tr></table></td></tr>';
                
                
            }
			
            if(objConf.arrRecursosAdicionalesRequeridos.length>0)
            {
                var arrRecursosAdicionales='';
                var oRecurso;
                var leyenda;
                var btnConRecurso;
                for(x=0;x<objConf.arrRecursosAdicionalesRequeridos.length;x++)
                {	
                	
                    oRecurso=objConf.arrRecursosAdicionalesRequeridos[x];
                    leyenda='('+oRecurso.tipoRecurso+') '+oRecurso.nombreRecurso;
                    if(arrRecursosAdicionales=='')
                        arrRecursosAdicionales=leyenda;
                    else
                        arrRecursosAdicionales+='<br>'+leyenda;
                    
                }
                tabla+='	<tr height="23"><td align="left"><span class="TSJDF_Etiqueta">Recursos adicionales requeridos:</span></td><td colspan="3" align="left"><span class="TSJDF_Control">'+arrRecursosAdicionales+'</span></td></tr>';
            }
			tabla+='<tr><td colspan="5" style="vertical-align:top"><br><span id="tblEspecificaciones"></span></td>';


            
            if(objConfRenderer.mostrarDesarrollo)
            {
                tabla+='	<tr height="23"><td align="left" colspan="4" ><br><span class="SeparadorSeccion" style="width:650px">Desarollo de la audiencia</span><br></td></tr>';
                if(objConfRenderer.mostrarDuracionDesarrollo)
            	{
                	tabla+='	<tr height="23"><td align="left"><span class="TSJDF_Etiqueta">Duraci&oacute;n de la audiencia:</span></td><td colspan="3" align="left"><span class="TSJDF_Control">'+duracionReal+'</span></td></tr>';
                }
                
                
                if((objConfRenderer.mostrarHorarioDesarrollo)||(objConfRenderer.permiteModificarHorarioDesarrollo))
            	{
                	tabla+='	<tr height="23"><td align="left"><span class="TSJDF_Etiqueta">Horario de desarrollo:</span></td><td colspan="3" align="left"><span class="TSJDF_Control">'+lblHorarioReal+'</span></td></tr>';
                }
                
                if(objConfRenderer.permiteModificarHorarioDesarrollo)
                {
                	tabla+='	<tr height="23"><td align="left"><span class="TSJDF_Etiqueta">Horario de desarrollo real:</span></td><td colspan="3" align="left"><span class="TSJDF_Control">'+
				            ' <table><tr><td>  De las </td><td width="5"></td><td><span id="hrsInicio"></span></td><td width="5"></td><td><span id="dteHInicio"></span></td><td width="5"></td><td> a las </td><td width="5"></td><td><span id="hrsFin"></span></td><td width="5"></td><td><span id="dteHFin"></span></td><td width="5"></td><td><span id="btnModificar"></span></td></tr></table></span></td></tr>';
                }
                
                
                
                if(objConfRenderer.mostrarDocumentoMultimedia)
            	{
                	tabla+='	<tr height="23"><td align="left"><span class="TSJDF_Etiqueta">Documento multimedia:</span></td><td colspan="3" align="left"><span class="TSJDF_Control"><a href="'+objConf.urlMultimedia+'">'+objConf.urlMultimedia+'</a></span></td></tr>';
               	}
			}
            
            
             
            
            
            tabla+='	</table>';
            
            var leyenda2='';        
       
            if(objConfRenderer.permiteModificarFecha)
            {
                if(leyenda2!='')
                    leyenda2+='/';
                leyenda2+='Fecha';   
            }  
            
            if(objConfRenderer.permiteModificarSala)
            {
                if(leyenda2!='')
                    leyenda2+='/';
                leyenda2+='Sala';
            }                      
        
            new Ext.Panel 	(
                                {
                                    renderTo:objConfiguracionTablero.renderTo,
                                    width:1000,
                                    height:500,
                                    tbar:	[
                                    			/*{
                                                    id:'btnRegistrarAcuerdo',
                                                    hidden:(lblAciones==''),
                                                    icon:formatearValorRenderer(arrSemaforo,'6'),
                                                    cls:'x-btn-text-icon',
                                                    text:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Registrar resoluci&oacute;n mediante acuerdo',
                                                    handler:function()
                                                            {
                                                                 mostrarVentanaFinalizarPorAcuerdo(idEventoAudiencia);
                                                            }
                                                    
                                                },'-',
                                                {
                                                    id:'btnCancelarAudiencia',
                                                    hidden:(lblAciones==''),
                                                    icon:formatearValorRenderer(arrSemaforo,'3'),
                                                    cls:'x-btn-text-icon',
                                                    text:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cancelar audiencia',
                                                    handler:function()
                                                            {
                                                                mostrarVentanaCancelarAudiencia(idEventoAudiencia);
                                                            }
                                                    
                                                },'-',*/
                                                 {
                                                    icon:'../images/pencil.png',
                                                    cls:'x-btn-text-icon',
                                                    hidden:(lblAciones==''),
                                                    text:'Modificar '+leyenda2,
                                                    handler:function()
                                                            {
                                                                mostrarModificacionEvento();
                                                            }
                                                    
                                                },'-',
                                                {
                                                    icon:'../images/page_edit.png',
                                                    cls:'x-btn-text-icon',
                                                    hidden:!objConfRenderer.permiteModificarRecurso,
                                                    text:'Modificar Recursos Adicionales',
                                                    handler:function()
                                                            {
                                                                mostrarVentanaRecursosAdicionales();
                                                            }
                                                    
                                                }
                                    			
                                    		],
                                    layout:'absolute',
                                    items:	[
                                    			{
                                                	xtype:'label',
                                                    x:20,
                                                    y:0,
                                                    html:tabla
                                                }
                                    		]
                                }
                            )                    
            			
            
            //tblDestino.innerHTML=tabla;
            

            if(typeof(afterLoadEvent)!='undefined')
            {
            	afterLoadEvent(objDatosAudiencia);
            }
            
            
            
            
            if(gE('cmbTipoAudicia'))
            {
	            llenarCombo(gE('cmbTipoAudicia'),arrTiposAudiencia);
                selElemCombo(gE('cmbTipoAudicia'),objConf.idTipoAudiencia);
            }
            
            if(objConfRenderer.permiteModificarHorarioDesarrollo)
            {
            	
                
                var hInicio=objConf.horaInicioReal==''?objConf.horaInicio:objConf.horaInicioReal;
                var hFin=objConf.horaFinReal==''?objConf.horaFin:objConf.horaFinReal;
                
                hInicio=Date.parseDate(hInicio,'Y-m-d H:i:s');
                hFin=Date.parseDate(hFin,'Y-m-d H:i:s');
                
                
                var horaInicial=new Date(2010,5,10,0,0);
				var horaFinal=new Date(2010,5,10,23,59);
                
                var arregloValores=generarIntervaloHoras(horaInicial,horaFinal,1,'H:i','H:i');
                crearComboExt('cmbHrsInicio',arregloValores,0,0,70,{renderTo:'hrsInicio'});
                
                gEx('cmbHrsInicio').setValue(hInicio.format('H:i'));
                
            	new Ext.form.DateField(	{id:'dteHoraInicio',renderTo:'dteHInicio',value:hInicio.format('Y-m-d')});
                crearComboExt('cmbHrsFin',arregloValores,0,0,70,{renderTo:'hrsFin'});
                
                gEx('cmbHrsFin').setValue(hFin.format('H:i'));
                
                new Ext.form.DateField(	{id:'dteHoraFin',renderTo:'dteHFin', value:hFin.format('Y-m-d')});
                
                new Ext.Button	(
                					{
                                    	width:100,
                                        renderTo:'btnModificar',
                                        icon:'../images/icon_big_tick.gif',
                                        cls:'x-btn-text-icon',
                                        text:'Guardar horario',
                                        handler:function()
                                                {
                                                    guardarModificacionHorario()
                                                }
                                    }
                				)
                
            }
            
            if(objConfRenderer.mostrarEspecificacionesEspeciales)
            {
            	new Ext.form.FieldSet(
                						{
                                        	renderTo:'tblEspecificaciones',
                                            width:850,
                                            height:120,
                                            title:'Requerimientos especiales (Opcional)',
                                            layout:'absolute',
                                            items:	[
                                            			{
                                                        	xtype:'checkbox',
                                                            x:10,
                                                            y:10,
                                                            checked:(objDatosAudiencia.requerimientosEspeciales.requiereResguardo=='1'),
                                                            listeners:	{
                                                            				check:function(ctrl,value)
                                                                            		{
                                                                                    	actualizarRequerimientoEspecial(1,value);
                                                                                    }
                                                           				},	
                                                            disabled:(lblAciones==''),
                                                            boxLabel:'<span class="TSJDF_Control">Requiere área de resguardo</span>'
                                                        },
                                                        {
                                                        	xtype:'checkbox',
                                                            x:260,
                                                            y:10,
                                                            listeners:	{
                                                            				check:function(ctrl,value)
                                                                            		{
                                                                                    	actualizarRequerimientoEspecial(2,value);
                                                                                    }
                                                           				},
                                                            disabled:(lblAciones==''),
                                                            checked:(objDatosAudiencia.requerimientosEspeciales.requiereTelePresencia=='1'),
                                                            boxLabel:'<span class="TSJDF_Control">Requiere Tele presencia</span>'
                                                        },
                                                        {
                                                        	xtype:'checkbox',
                                                            x:10,
                                                            y:40,
                                                            disabled:(lblAciones==''),
                                                            listeners:	{
                                                            				check:function(ctrl,value)
                                                                            		{
                                                                                    	actualizarRequerimientoEspecial(3,value);
                                                                                    }
                                                           				},
                                                            checked:(objDatosAudiencia.requerimientosEspeciales.requiereMesaEvidencia=='1'),
                                                            boxLabel:'<span class="TSJDF_Control">Requiere mesa de evidencia</span>'
                                                        },
                                                        {
                                                        	xtype:'checkbox',
                                                            x:260,
                                                            y:40,
                                                            disabled:(lblAciones==''),
                                                            listeners:	{
                                                            				check:function(ctrl,value)
                                                                            		{
                                                                                    	actualizarRequerimientoEspecial(4,value);
                                                                                    }
                                                           				},
                                                            checked:(objDatosAudiencia.requerimientosEspeciales.requiereTestigoProtegido=='1'),
                                                            boxLabel:'<span class="TSJDF_Control">Requiere modalidad de testigo protegido</span>'
                                                        }
                                                        
                                            		]
                                            
                                        }
                					)
            }
            
            if(lblAciones!='')
            {
            	
            	var objCombo={};
                objCombo.renderTo='spNombreAuxiliar';
            	crearComboExt('cmbAuxiliarSala',[],0,0,300,objCombo)

            	construirBotones(objConfRenderer);
                
                obtenerAuxiliarDisponibles(objConf.idAuxiliarSala);
                new Ext.Button (
                                    {
                                        icon:'../images/user_go.png',
                                        cls:'x-btn-text-icon',
                                        text:'Asignar auxiliar',
                                        width:150,
                                        x:20,
                                        height:25,
                                        renderTo:'tblAsignar',
                                        handler:function()
                                                {
                                                    var idAuxiliar='';
                                                    var AuxiliarSala=gEx('cmbAuxiliarSala');
                                                    if(AuxiliarSala.getValue()=='')
                                                    {
                                                    	function respAuxiliarSala()
                                                        {
                                                        	AuxiliarSala.focus(false,500);
                                                        }
                                                        msgBox('Debe seleccionar el auxiliar de audiencia a asignar',AuxiliarSala);
                                                        return;
                                                    }
                                                    
                                                    idAuxiliar=AuxiliarSala.getValue();
                                                    
                                                    function funcAjax()
                                                    {
                                                        var resp=peticion_http.responseText;
                                                        arrResp=resp.split('|');
                                                        if(arrResp[0]=='1')
                                                        {
                                                            window.parent.mostrarMenuDTD();
                                                        }
                                                        else
                                                        {
                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                        }
                                                    }
                                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=30&iE='+idEvento+
                                                                '&iA='+idAuxiliar,true);
                                                }
                                        
                                    }
                                )  
            }
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=11&iE='+objConfRenderer.idEvento,false);
    
}

function convertirFechaToLetra(fecha,incluirDia)
{
	var leyenda='';
    var fechaConvertir=Date.parseDate(fecha,'Y-m-d');
    
    if(incluirDia)
    {
    	leyenda=arrDias[fechaConvertir.format("w")]+' ';
    }
    leyenda+=fechaConvertir.format('d')+' de '+arrMeses[parseInt(fechaConvertir.format('m'))-1][1]+' de '+fechaConvertir.format('Y');
    
    return leyenda;
    
}

function construirBotones(objConfRenderer)
{
	return;
	if(gE('btnModificacionUG'))
    {
    
    	var leyenda='';
    	if(objConfRenderer.permiteModificarEdificio)
        {
        	leyenda='Edificio';
        }
    	
        if(objConfRenderer.permiteModificarUnidadGestion)
        {
        	if(leyenda!='')
            	leyenda+='/';
            leyenda+='Unidad de Gesti&oacute;n';   
        }
        new Ext.Button (
                                {
                                    icon:'../images/pencil.png',
                                    iconAlign:'left', 
                                    cls:'x-btn-text-icon',
                                    text:'Modificar '+leyenda,
                                    width:230,
                                    height:25,
                                    renderTo:'btnModificacionUG',
                                    handler:function()
                                            {
                                                mostrarModificacionUnidadGestion('Modificar '+leyenda);
                                            }
                                    
                                }
                            )
                            
	}  
    
    if(gE('btnModificacionSala'))
    {
		var leyenda2='';
        
       
        if(objConfRenderer.permiteModificarFecha)
        {
        	if(leyenda2!='')
            	leyenda2+='/';
            leyenda2+='Fecha';   
        }  
        
    	if(objConfRenderer.permiteModificarSala)
        {
        	if(leyenda2!='')
            	leyenda2+='/';
        	leyenda2+='Sala';
        }
    	
        
        
        
                                   
        new Ext.Button (
                                {
                                    icon:'../images/pencil.png',
                                    cls:'x-btn-text-icon',
                                    iconAlign:'left',
                                    text:'Modificar '+leyenda2,
                                    width:180,
                                    height:25,
                                    renderTo:'btnModificacionSala',
                                    handler:function()
                                            {
                                                mostrarModificacionEvento();
                                            }
                                    
                                }
                            )
                            
                            
                            
                            
                            
		new Ext.Button (
                                {
                                    icon:formatearValorRenderer(arrSemaforo,'3'),
                                    cls:'x-btn-text-icon',
                                    iconAlign:'left',
                                    text:'Cancelar audiencia',
                                    width:180,
                                    height:25,
                                    renderTo:'btnCancelarAudiencia',
                                    handler:function()
                                            {
                                                mostrarVentanaCancelarAudiencia(idEventoAudiencia);
                                            }
                                    
                                }
                            )
                            
                            
		new Ext.Button (
                                {
                                    icon:formatearValorRenderer(arrSemaforo,'6'),
                                    cls:'x-btn-text-icon',
                                    iconAlign:'left',
                                    text:'Resolver por acuerdo ',
                                    width:180,
                                    height:25,
                                    renderTo:'btnResolverAcuerdo',
                                    handler:function()
                                            {
                                                mostrarVentanaFinalizarPorAcuerdo(idEventoAudiencia);
                                            }
                                    
                                }
                            )                                                        
	}
}

function recargarContenedorCentral()
{
	recargarPagina();
}

function abrirFormatoRegistro(iF,iR)
{
	var obj={};    
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modeloPerfiles/vistaDTDv3.php';
    obj.params=[['idFormulario',bD(iF)],['idRegistro',bD(iR)],
                ['dComp',bE('auto')],['actor',bE(0)]];
    window.parent.abrirVentanaFancy(obj);
}

function cmbTipoAudienciaChange(cmb)
{
	var tipoAudiencia=cmb.options[cmb.selectedIndex].value;
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=69&iE='+idEventoAudiencia+'&tA='+tipoAudiencia,true);
  
}

function guardarModificacionHorario()
{
	var cmbHrsInicio=gEx('cmbHrsInicio');
    
    if(cmbHrsInicio.getValue()=='')
    {
    	msgBox('Debe indicar la hora de inicio de la audiencia');
    	return;
    }
    
    var dteHoraInicio=gEx('dteHoraInicio');
    if(dteHoraInicio.getValue()=='')
    {
    	msgBox('Debe indicar la fecha de inicio de la audiencia');
    	return;
    }
    
    
    var cmbHrsFin=gEx('cmbHrsFin');
     if(cmbHrsFin.getValue()=='')
    {
    	msgBox('Debe indicar la hora de t&eacute;rmino de la audiencia');
    	return;
    }
    
    
    var dteHoraFin=gEx('dteHoraFin');
    if(dteHoraFin.getValue()=='')
    {
    	msgBox('Debe indicar la fecha de t&eacute;rmino de la audiencia');
    	return;
    }
    

	var hInicio=Date.parseDate(dteHoraInicio.getValue().format('Y-m-d')+' '+cmbHrsInicio.getValue(),'Y-m-d H:i');
    var hFin=Date.parseDate(dteHoraFin.getValue().format('Y-m-d')+' '+cmbHrsFin.getValue(),'Y-m-d H:i');
    
    if(hInicio>hFin)
    {
    	msgBox('La hora de inicio NO puede ser mayor que la hora de t&eacute;rmino')
    	return;
    }
    
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	function resp()
            {
            	construirTableroEvento(objConfiguracionTablero);
            }
            msgBox('Los datos han sido guardados correctamente',resp);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=71&iE='+idEventoAudiencia+'&hInicio='+
    				hInicio.format('Y-m-d H:i:s')+'&hFin='+hFin.format('Y-m-d H:i:s'),true);

    
}

function actualizarRequerimientoEspecial(tipoRequerimiento,valor)
{
	var cadObj='{"tipoRequerimiento":"'+tipoRequerimiento+'","valor":"'+((valor)?1:0)+'","idFormulario":"'+gE('idFormulario').value+
    			'","idRegistro":"'+gE('idRegistro').value+'"}';
	function funcAjaxV2(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjaxV2, 'POST','funcion=98&cadObj='+cadObj,true);
}

function obtenerAuxiliarDisponibles(valorSel)
{
	function funcAjax2()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
			var arrDatos=eval(arrResp[1]);
            arrDatos.splice(0,0,['0','No aplica']);
            gEx('cmbAuxiliarSala').getStore().loadData(arrDatos);
            if((valorSel)&&(valorSel!='-1'))
            {
            	gEx('cmbAuxiliarSala').setValue(valorSel);
            }
                 
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax2, 'POST','funcion=29&idEvento='+idEventoAudiencia,true);
}

function abrirCarpetaJudicial()
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJP/tableroAudienciaAdministracion.php';
    obj.params=[['sL',1],['cA',bE(objDatosAudiencia.carpetaJudicial)],['idCarpetaAdministrativa',(objDatosAudiencia.idCarpeta)]];
	
    abrirVentanaFancy(obj);
}


function mostrarVentanaRecursosAdicionales()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			crearGridRecursosAdicionales()
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Modificar Recursos Adicionales',
										width: 850,
										height:450,
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
															text: 'Cerrar',
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


function crearGridRecursosAdicionales()
{
	regRecursosAdicionales=crearRegistro	(
                                                [
                                                    {name:'idRegistro'},
                                                    {name: 'tipoRecurso'},
                                                    {name:'idRecurso'},
                                                    {name:'horaInicio', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                    {name:'horaTermino', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                    {name: 'comentariosAdicionales'},
                                                    {name: 'alertas'}
                                                ]
                                            );
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'tipoRecurso'},
		                                                {name:'idRecurso'},
		                                                {name:'horaInicio', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name:'horaTermino', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'comentariosAdicionales'},
                                                        {name: 'alertas'}
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
                                                            sortInfo: {field: 'idRecurso', direction: 'ASC'},
                                                            groupField: 'tipoRecurso',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='304';
                                        proxy.baseParams.idEventoAudiencia=idEventoAudiencia;
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'alertas'
                                                            },
                                                            {
                                                                header:'Tipo de recurso',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'tipoRecurso',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrTiposRecurso,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Recurso',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'idRecurso',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrRecursos,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Hora de uso',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'horaInicio',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var lblEtiqueta=val.format('H:i')+' - '+registro.data.horaTermino.format('H:i');
                                                                            if(val.format('Y-m-d')!=registro.data.horaTermino.format('Y-m-d'))
                                                                            {
                                                                            	lblEtiqueta+=' ('+registro.data.horaTermino.format('d/m/Y')+')';	
                                                                            }
                                                                            return lblEtiqueta;
                                                                        }
                                                            },
                                                            {
                                                                header:'Comentarios adicionales',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'comentariosAdicionales',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return mostrarValorDescripcion(val);
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gRecursosAdicionales',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                tbar:	[
                                                                			{
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Agregar recurso',
                                                                                handler:function()
                                                                                        {
                                                                                        
                                                                                        	
                                                                                           	mostrarVentanaAgregarRecursoAudiencia(); 
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/pencil.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Modificar recurso',
                                                                                handler:function()
                                                                                        {
                                                                                        
                                                                                        	var recurso=gEx('gRecursosAdicionales').getSelectionModel().getSelected();
                                                                                            if(!recurso)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar el recurso que desea modificar');
                                                                                            	return;
                                                                                            }
                                                                                           	mostrarVentanaAgregarRecursoAudiencia(recurso); 
                                                                                        }
                                                                                
                                                                            }
                                                                            
                                                                            
                                                                            ,'-',
                                                                            {
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Remover recurso',
                                                                                handler:function()
                                                                                        {
                                                                                            var fila=gEx('gRecursosAdicionales').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar el recurso que desea remover');
                                                                                            	return;
                                                                                            }
                                                                                            if(fila.data.idRegistro==-1)
                                                                                            {
                                                                                            	function resp(btn)
                                                                                                {
                                                                                                	if(btn=='yes')
                                                                                                    {
                                                                                                    	gEx('gRecursosAdicionales').getStore().remove(fila);
                                                                                                        if(gEx('chkVisualizarAgendaRecursos').getValue())
                                                                                                        {
                                                                                                            cargarDatosAgenda();
                                                                                                        }
                                                                                                    }
                                                                                                }
                                                                                                msgConfirm('Est&aacute; seguro de querer remover el recurso seleccionado?',resp);
                                                                                            	
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                            	mostrarVentanaRemoverRecurso(fila); 
                                                                                            }
                                                                                           	
                                                                                           
                                                                                        }
                                                                                
                                                                            }
                                                                            
                                                                		],
                                                                        
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :true,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: true,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
        return 	tblGrid;
}



function mostrarVentanaAgregarRecursoAudiencia(fRecurso)
{
	idRegistroRecursoIng=fRecurso?fRecurso.data.idRegistro:-1;
	var cmbTipoRecurso=crearComboExt('cmbTipoRecurso',arrTiposRecurso,140,5,200);
    cmbTipoRecurso.on('select',	function(cmb,registro)
    							{
                                	function funcAjax()
                                    {
                                        var resp=peticion_http.responseText;
                                        arrResp=resp.split('|');
                                        if(arrResp[0]=='1')
                                        {
                                        	gEx('cmbNombreRecurso').setValue('');
                                            var arrRecursos=eval(arrResp[1]);
                                            gEx('cmbNombreRecurso').getStore().loadData(arrRecursos);
                                        }
                                        else
                                        {
                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                        }
                                    }
                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=302&tR='+registro.data.id,true);
                                    
                                    
                                }
    				)
    
    
    
    
    var cmbNombreRecurso=crearComboExt('cmbNombreRecurso',[],10,65,330);
	cmbNombreRecurso.on('select',function()
    							{
                                	cargarDatosAgendaRecursosEvento();
                                }
    					)
    
    
    
    var cmbHoraInicial=crearComboExt('cmbHoraInicial',arrHoras,245,95,95);
    cmbHoraInicial.setValue(Date.parseDate(objDatosAudiencia.horaInicio,'Y-m-d h:i:s').format('H:i'));
    cmbHoraInicial.on('select',function(cmb,registro)
    								{
	                                    calcularHoraFinalRecursoAudiencia(registro.data.id);
                                    }
    					)
    
    
    
    var cmbHoraFinal=crearComboExt('cmbHoraFinal',arrHoras,140,125,95);
    
    cmbHoraFinal.setValue(Date.parseDate(objDatosAudiencia.horaFin,'Y-m-d h:i:s').format('H:i'));

    cmbHoraFinal.on('select',function(cmb,registro)
    								{
	                                    calcularTiempoEstimadoAudiencia();
                                    }
    					)
    
                                                                                                                            
                                                                                                                            
    
    
    var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	xtype:'panel',
                                                            region:'center',
                                                            items:	[
                                                            			new Ext.ux.IFrameComponent({ 
                
                                                                                                          id: 'frameContenidoAgendaRecursos', 
                                                                                                          anchor:'100% 100%',
                                                                                                          region:'center',
                                                                                                          border:true,
                                                                                                          loadFuncion:function(iFrame)
                                                                                                                      {
                                                                                                                          //autofitIframe(iFrame);
                                                                                                                      },
            
                                                                                                          url: '../paginasFunciones/white.php',
                                                                                                          style: 'width:100%;height:370px' 
                                                                                                  })
                                                            		]
                                                        },
                                                        {
                                                        	xtype:'panel',
                                                            region:'east',
                                                            width:350,
                                                            layout:'absolute',
                                                            items:	[
                                                            			{
                                                                        	x:10,
                                                                            y:10,
                                                                            xtype:'label',
                                                                            html:'<b>Tipo de recurso:</b>'
                                                                        },
                                                                        cmbTipoRecurso,
                                                                        {
                                                                        	x:10,
                                                                            y:40,
                                                                            xtype:'label',
                                                                            html:'<b>Nombre del recurso:</b>'
                                                                        },
                                                                        cmbNombreRecurso,
                                                                        {
                                                                        	x:10,
                                                                            y:100,
                                                                            xtype:'label',
                                                                            html:'<b>Horario requerido:</b>'
                                                                        },
                                                                        {
                                                                        	x:102,
                                                                            y:130,
                                                                            xtype:'label',
                                                                            html:'<b>a:</b>'
                                                                        },
                                                                        {
                                                                        	xtype:'datefield',
                                                                            x:140,
                                                                            y:95,
                                                                            disabled:true,
                                                                            width:95,
                                                                            value:objDatosAudiencia.fechaEvento,
                                                                            id:'dteHoraInicial'
                                                                        },
                                                                        cmbHoraInicial,
                                                                        cmbHoraFinal,
                                                                        {
                                                                        	xtype:'datefield',
                                                                            x:245,
                                                                            y:125,
                                                                            width:95,
                                                                            value:objDatosAudiencia.fechaEvento,
                                                                            id:'dteHoraFinal'
                                                                        },
                                                                        {
                                                                        	x:10,
                                                                            y:160,
                                                                            xtype:'label',
                                                                            html:'<b>Comentarios adicionales:</b>'
                                                                        },
                                                                        {
                                                                        	x:10,
                                                                            y:190,
                                                                            xtype:'textarea',
                                                                            width:330,
                                                                            height:45,
                                                                            id:'comentariosAdicionalesRecurso'
                                                                        },
                                                                        {
                                                                        	x:10,
                                                                            y:265,
                                                                            hidden:!fRecurso,
                                                                            xtype:'label',
                                                                            html:'<b>Motivo del cambio:</b>'
                                                                        },
                                                                        {
                                                                        	x:10,
                                                                            y:295,
                                                                            xtype:'textarea',
                                                                            width:330,
                                                                            height:60,
                                                                            hidden:!fRecurso,
                                                                            id:'motivoCambio'
                                                                        }
                                                                        
                                                            		]
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: (fRecurso?'Modificar':'Agregar')+' recurso a audiencia',
										width: 900,
										height:450,
                                        id:'vAgregarRecurso',
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
                                                            id:'btnAceptarRecursos',
                                                            disabled:true,
															handler: function()
																	{
																		var dteHoraInicial=gEx('dteHoraInicial');
                                                                        var cmbHoraInicial=gEx('cmbHoraInicial');
                                                                        var dteHoraFinal=gEx('dteHoraFinal');
                                                                        var cmbHoraFinal=gEx('cmbHoraFinal');
                                                                        
                                                                        
                                                                        if(cmbNombreRecurso.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	cmbNombreRecurso.focus();
                                                                            }
                                                                            msgBox('Debe indicar el recurso que desea agregar',resp1)
                                                                        	return;
                                                                        }
                                                                        
                                                                        var fInicial=Date.parseDate(dteHoraInicial.getValue().format('Y-m-d')+' '+cmbHoraInicial.getValue(),'Y-m-d H:i');
                                                                        var fFinal=Date.parseDate(dteHoraFinal.getValue().format('Y-m-d')+' '+cmbHoraFinal.getValue(),'Y-m-d H:i');
                                                                        if(fInicial>fFinal)
                                                                        {
                                                                        	function respAux()
                                                                            {
                                                                            	dteHoraInicial.focus();
                                                                            }
                                                                            msgBox('La hora de inicio NO puede ser mayor que la hora de t&eacute;rmino',respAux);
                                                                        	return;
                                                                        }
                                                                        
                                                                        
                                                                        var fechaInicialAudiencia=Date.parseDate(objDatosAudiencia.horaInicio,'Y-m-d H:i');
    
                                                                        var fechaFinalAudiencia=Date.parseDate(objDatosAudiencia.horaFin,'Y-m-d H:i');
    
                                                                        
                                                                        /*if(fInicial<fechaInicialAudiencia)
                                                                        {
                                                                        	function respAux2()
                                                                            {
                                                                            	dteHoraInicial.focus();
                                                                            }
                                                                            msgBox('La hora de inicio NO puede ser mayor que la hora de t&eacute;rmino',respAux2);
                                                                        	return;
                                                                        }*/
                                                                        
                                                                        var idRegistroRecurso=idRegistroRecursoIng;
                                                                        
                                                                        if(idRegistroRecurso!=-1)
                                                                        {
                                                                        	if(gEx('motivoCambio').getValue()=='')
                                                                            {
                                                                            	function respAux()
                                                                                {
                                                                                	gEx('motivoCambio').focus(false,500);
                                                                                }
                                                                            	msgBox('Debe indicar el motivo del cambio',respAux);
                                                                            	return;
                                                                            }
                                                                        }
                                                                        
                                                                        
                                                                        var x;
                                                                        var gRecursosAdicionales=gEx('gRecursosAdicionales');
                                                                        
                                                                        var fila;
                                                                        var enc=false;
                                                                        for(x=0;x<gRecursosAdicionales.getStore().getCount();x++)
                                                                        {
                                                                        	fila=gRecursosAdicionales.getStore().getAt(x);
                                                                            if((fila.data.tipoRecurso==cmbTipoRecurso.getValue())&&(fila.data.idRecurso==cmbNombreRecurso.getValue()&&(fila.data.idRegistro!=idRegistroRecurso)))
                                                                            {
                                                                            	enc=true;
                                                                                break;
                                                                            }
                                                                        }
                                                                        
                                                                        if(enc)
                                                                        {
                                                                        	msgBox('El recurso a agregar ya ha sido registrado previamente en esta audiencia');
                                                                        	return;
                                                                        }
                                                                        
                                                                        var cadObj='{"tipoRecurso":"'+gEx('cmbTipoRecurso').getValue()+'","idRecurso":"'+gEx('cmbNombreRecurso').getValue()+
                                                                        			'","horaInicio":"'+fInicial.format('Y-m-d H:i:s')+'","horaTermino":"'+fFinal.format('Y-m-d H:i:s')+
                                                                                    '","idRegistroRecurso":"'+idRegistroRecurso+'","idRegistroEvento":"'+idEventoAudiencia+
                                                                                    '","comentariosAdicionales":"'+cv(gEx('comentariosAdicionalesRecurso').getValue())+
                                                                                    '","motivoCambio":"'+cv(gEx('motivoCambio').getValue())+'"}';
                                                                        
                                                                        if(idRegistroRecurso==-1)
                                                                        {	
                                                                        	guardarRecursoAdicional(cadObj);
                                                                        }
                                                                        else
                                                                        {
                                                                        	function resp(btn)
                                                                            {
                                                                            	if(btn=='yes')
                                                                                {
                                                                                	guardarRecursoAdicional(cadObj);
                                                                                }
                                                                            }
                                                                            msgConfirm('Est&aacute; seguro de querer modificar la informaci&oacute;n del recurso?',resp);
                                                                        }
                                                                        
                                                                        
                                                                        
                                                                        
                                                                       
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
    
    if(fRecurso)
    {
    	cmbTipoRecurso.setValue(fRecurso.data.tipoRecurso);
        cmbHoraInicial.setValue(fRecurso.data.horaInicio.format("H:i"));
        cmbHoraFinal.setValue(fRecurso.data.horaTermino.format("H:i"));
        gEx('dteHoraInicial').setValue(fRecurso.data.horaInicio);
        gEx('dteHoraFinal').setValue(fRecurso.data.horaTermino);
        gEx('comentariosAdicionalesRecurso').setValue(escaparBR(fRecurso.data.comentariosAdicionales,true));
        function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
                
                var arrRecursos=eval(arrResp[1]);
                gEx('cmbNombreRecurso').getStore().loadData(arrRecursos);
                gEx('cmbNombreRecurso').setValue(fRecurso.data.idRecurso);
                dispararEventoSelectCombo('cmbNombreRecurso');
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=302&tR='+fRecurso.data.tipoRecurso,true);
    }
    
    
    var horaInicio=Date.parseDate(gEx('dteHoraInicial').getValue().format('Y-m-d')+' '+cmbHoraInicial.getValue(),'Y-m-d H:i');
    var horaFin=Date.parseDate(gEx('dteHoraFinal').getValue().format('Y-m-d')+' '+cmbHoraFinal.getValue(),'Y-m-d H:i')
    lblDuracionRecursoAudiencia=((horaFin-horaInicio+0)/60000);	
	
}


function guardarRecursoAdicional(cadObj)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	construirTableroEvento(objConfiguracionTablero);
            gEx('gRecursosAdicionales').getStore().reload();
            gEx('vAgregarRecurso').close();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=308&cadObj='+cadObj,true);
          
}

function cargarDatosAgendaRecursosEvento()
{
	if(gEx('cmbNombreRecurso').getValue()=='')
    {
    	gEx('frameContenidoAgendaRecursos').load	(
                                                        {
                                                            url:'../paginasFunciones/white.php'

                                                        }
                                                    )
    	return;
    }
   

    
    var oParams={
                    tipoRecurso:gEx('cmbTipoRecurso').getValue(),
                    cPagina:'sFrm=true',
                    idRecurso:gEx('cmbNombreRecurso').getValue() ,
                    fechaBase: gEx('dteHoraInicial').getValue().format('Y-m-d'),
                    idRegistroRecurso:idRegistroRecursoIng
                    
                }
    
    
	gEx('frameContenidoAgendaRecursos').load	(
                                                    {
                                                        url:'../modulosEspeciales_SGJP/calendarioEventosRecursosAudiencia.php',
                                                        params:	oParams
                                                    }
                                                )
}

function calcularHoraFinalRecursoAudiencia(horaInicial)
{
	
	var duracionOriginal=parseInt(lblDuracionRecursoAudiencia);
    
	var fechaInicio=gEx('dteHoraInicial').getValue().format('Y-m-d');
    fechaInicio+=' '+horaInicial;
    
    var dteFechaInicio=Date.parseDate(fechaInicio,'Y-m-d H:i');
   
    var dteFechaFin=dteFechaInicio.add(Date.MINUTE,duracionOriginal);
    
    
	gEx('cmbHoraFinal').setValue(dteFechaFin.format('H:i')); 
    
    gEx('cmbHoraInicial').setValue(dteFechaInicio.format('H:i')); 
   	gEx('dteHoraFinal').setValue(dteFechaFin.format('Y-m-d'));
    
    
    
    
    calcularTiempoEstimadoAudiencia();   
   
    
       
}

function calcularTiempoEstimadoAudiencia()
{
	var horaInicio=Date.parseDate(gEx('dteHoraInicial').getValue().format('Y-m-d')+' '+gEx('cmbHoraInicial').getValue(),'Y-m-d H:i');
    var horaFin=Date.parseDate(gEx('dteHoraFinal').getValue().format('Y-m-d')+' '+gEx('cmbHoraFinal').getValue(),'Y-m-d H:i');
	lblDuracionRecursoAudiencia=((horaFin-horaInicio+0)/60000);
    
    ajustarEventoRecursoAudiencia();
}

function ajustarEventoRecursoAudiencia()
{
	var calendario=gEx('frameContenidoAgendaRecursos').getFrameWindow();	
    var horaInicio=Date.parseDate(gEx('dteHoraInicial').getValue().format('Y-m-d')+' '+gEx('cmbHoraInicial').getValue(),'Y-m-d H:i');
   
    var horaFin=Date.parseDate(gEx('dteHoraFinal').getValue().format('Y-m-d')+' '+gEx('cmbHoraFinal').getValue(),'Y-m-d H:i');
	
    
    
    if(calendario.$)
    {
    	var evento=calendario.$('#calendar').fullCalendar( 'clientEvents' ,'e_'+calendario.gE('idRegistroRecurso').value )[0];
        if(evento)
        {
            var horaInicioAnterior=evento.start;
            var horaFinAnterior=evento.end;
            
            evento.start=moment(horaInicio);
            evento.end=moment(horaFin);
            if(calendario.existeTraslape(evento))
            {
                
                function resp22()
                {
                    evento.start=Date.parseDate(moment(horaInicioAnterior).format("YYYY-MM-DD HH:mm:ss"),'Y-m-d H:i:s');
                    evento.end=Date.parseDate(moment(horaFinAnterior).format("YYYY-MM-DD HH:mm:ss"),'Y-m-d H:i:s');
                    var fechaEvento=evento.start.format('Y-m-d');
                    
                    gEx('txtFechaEvento').setValue(fechaEvento);
                    gEx('cmbHoraInicio').setValue(evento.start.format('H:i:s'));
                    gEx('cmbHoraTermino').setValue(evento.end.format('H:i:s'));
                    var registro=calendario.$('#calendar').fullCalendar('updateEvent', evento);
                    
                       
                }
                msgBox('Ya existe un evento asignado en el horario que pretende programar',resp22);
                return;
            }
            evento.start=horaInicio;
            evento.end=horaFin;
            var registro=calendario.$('#calendar').fullCalendar('updateEvent', evento);
       }
       else
       {
       		var evento=	{};
            evento.id='e_'+calendario.gE('idRegistroRecurso').value;
            evento.title='';
            evento.allDay=false;
            evento.start=moment(horaInicio);
            evento.end=moment(horaFin);
            evento.editable=true;
            evento.color='#900';
            var traslape=calendario.existeTraslape(evento);
            if(traslape)
            {
                function resp()
                {
                    
                    
                }
                msgBox('Ya existe un evento asignado en el horario que pretende programar',resp);
                return;
            }
            calendario.$('#calendar').fullCalendar('renderEvent', evento);
       }
	}
   
}

function ajustarFechaRecursoAudiencia(evento)
{

	gEx('dteHoraInicial').setValue(evento.start.format('YYYY-MM-DD'));
    gEx('cmbHoraInicial').setValue(evento.start.format('HH:mm'));    
    gEx('cmbHoraFinal').setValue(evento.end.format('HH:mm'));
	gEx('dteHoraFinal').setValue(evento.end.format('YYYY-MM-DD'));
    calcularTiempoEstimadoAudiencia();
}

function mostrarVentanaRemoverRecurso(fila)
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
                                                            html:'Indique el motivo por el cual remueve el recurso:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            xtype:'textarea',
                                                            width:560,
                                                            height:60,
                                                            id:'motivoRemueveRecurso'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Remover recurso',
										width: 600,
										height:180,
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
                                                                	gEx('motivoRemueveRecurso').focus(false,true);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
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
                                                                                    	construirTableroEvento(objConfiguracionTablero);
                                                                                        gEx('gRecursosAdicionales').getStore().reload();
                                                                                        ventanaAM.close();
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=307&iE='+idEventoAudiencia+'&iR='+fila.data.idRegistro+'&mC='+cv(gEx('motivoRemueveRecurso').getValue()),true);
                                                                                                                                                                
                                                                                
                                                                            }
                                                                        }
                                                                        msgConfirm('Est&aacute; seguro de querer remover el recurso seleccionado?',resp);
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

function ajustarRecursosAdicionalesAudiencia(fechaInicial,fechaFinal)
{
	var fInicialRecurso;
    var fFinalRecurso;
	var fInicialActual=Date.parseDate(gEx('dteFecha').getValue().format('Y-m-d')+' '+gEx('tmeHoraInicio').getValue(),'Y-m-d H:i');
    var fFinalActual=Date.parseDate(gEx('dteFecha').getValue().format('Y-m-d')+' '+gEx('tmeHoraFin').getValue(),'Y-m-d H:i');
    
    var diferenciaHInicio=((fInicialActual-fechaInicial+0)/60000);
    var diferenciaHFin=((fFinalActual-fechaFinal+0)/60000);
    var diferenciaRecurso;
    var diferenciaHoraInicialRecurso;
   
	var gRecursosAdicionales=gEx('gRecursosAdicionales');
    var x;
    var fila;
    for(x=0;x<gRecursosAdicionales.getStore().getCount();x++)
    {
    	fila=gRecursosAdicionales.getStore().getAt(x);
        diferenciaRecurso=(fila.data.horaTermino-fila.data.horaInicio+0)/60000;
    	if((fila.data.horaInicio.format('Y-m-d H:i:s')==fechaInicial.format('Y-m-d H:i:s'))&&((fila.data.horaTermino.format('Y-m-d H:i:s')==fechaFinal.format('Y-m-d H:i:s'))))
        {	
        	fila.set('horaInicio',fInicialActual);
            fila.set('horaTermino',fFinalActual);
        }
        else
        {

        	diferenciaHoraInicialRecurso=(fila.data.horaInicio-fechaInicial+0)/60000;	
            fInicialRecurso=fInicialActual.add(Date.MINUTE,diferenciaHoraInicialRecurso);
            fFinalRecurso=fInicialRecurso.add(Date.MINUTE,diferenciaRecurso);
            
            if(fFinalRecurso>fFinalActual)
            {
            	fFinalRecurso=fFinalActual;
            }
            
            fila.set('horaInicio',fInicialRecurso);
            fila.set('horaTermino',fFinalRecurso);
            
        }
    }
}