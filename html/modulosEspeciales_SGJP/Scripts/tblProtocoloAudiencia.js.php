<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT id__348_tablaDinamica,nombreProtocolo FROM _348_tablaDinamica";
	$arrProcolos=$con->obtenerFilasArreglo($consulta);
?>

var arrProcolos=<?php echo $arrProcolos?>;
Ext.onReady(inicializar);

function inicializar()
{
	
    new Ext.Button (
                      {
                          icon:'../images/film_go.png',
                          cls:'x-btn-text-icon',
                          text:'Capturar momento',
                          width:110,
                          height:30,
                          renderTo:'spBtnCapturar',
                          handler:function()
                                  {
                                      var segundo=gE('myVideo').currentTime;
                                      var fila=gEx('gProcolo').getSelectionModel().getSelected();
                                      if(!fila)
                                      {
                                      		msgBox('Debe seleccionar el aspecto del protocolo con el cual desea vincular el momento capturado');
                                      		return;
                                      }
                                      fila.set('realizado',true)
                                      fila.set('horaRealizacion',Date.parseDate(gE('horaInicio').value,'H:i').add(Date.SECOND,segundo).format("H:i"));
                                      fila.set('segundosRealizacion',Date.parseDate(gE('horaInicio').value,'H:i').add(Date.SECOND,segundo).format("s"))
                                  }
                          
                      }
                  )
                  
	new Ext.Button (
                      {
                          icon:'../images/cancel_round.png',
                          cls:'x-btn-text-icon',
                          text:'Cerrar',
                          width:110,
                          height:30,
                          renderTo:'spCerrarVideo',
                          handler:function()
                                  {
                                        gE('myVideo').pause();
                                        gE('myVideo').currentTime=0;
										oE('spVideo');
                                  }
                          
                      }
                  )
                                    
	crearGridProcoloAudiencia();
    $( "#spVideo" ).draggable();
}

function crearGridProcoloAudiencia()
{

	
	var horaInicial=new Date(2010,5,10,0,0);
	var horaFinal=new Date(2010,5,10,23,59);
	
    
	var arrHoras=generarIntervaloHoras(horaInicial,horaFinal,1,'H:i','H:i');

	var arrSegundos=[];
    for(s=0;s<60;s++)
    {
    	var valor;
        if(s<10)
        	valor='0'+s;
        else
        	valor=''+s;
        
        arrSegundos.push([valor,valor]);
    }
    var cmbSegundos=crearComboExt('cmbSegundos',arrSegundos);
    var cmbHoraAudiencia=crearComboExt('cmbHoraAudiencia',arrHoras);
    
    
    
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'llave'},
		                                                {name: 'protocolo'},
		                                                {name: 'responsable'},
		                                                {name: 'realizado'},
                                                        {name: 'horaRealizacion'},
                                                        {name: 'segundosRealizacion'},
                                                        {name: 'comentariosAdicionales'}
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
                                                            sortInfo: {field: 'responsable', direction: 'ASC'},
                                                            groupField: 'responsable',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='84';
                                        proxy.baseParams.idEvento=gE('idEvento').value;
                                    }
                        )   
       
       
    var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});   
	var checkColumn = new Ext.grid.CheckColumn	(
	 												{
													   header: 'Realizado',
													   dataIndex: 'realizado',
													   width: 70
													}
												);       
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            chkRow,
                                                            {
                                                                header:'Protocolo',
                                                                width:450,
                                                                sortable:true,
                                                                dataIndex:'protocolo',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrProcolos,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Responsable',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'responsable'
                                                            },
                                                            checkColumn,
                                                            {
                                                                header:'Hora : minuto<br>realizaci&oacute;n',
                                                                width:85,
                                                                sortable:true,
                                                                editor:cmbHoraAudiencia,
                                                                dataIndex:'horaRealizacion'
                                                            },
                                                            {
                                                                header:'Segundo',
                                                                width:70,
                                                                sortable:true,
                                                                editor:cmbSegundos,
                                                                dataIndex:'segundosRealizacion'
                                                            },
                                                            {
                                                                header:'Comentarios adicionales',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'comentariosAdicionales',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.replace(/\n/gi,'<br />');
                                                                        },
                                                                editor:	{
                                                                			xtype:'textarea'
                                                                		}
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                            {
                                                                id:'gProcolo',
                                                                store:alDatos,
                                                                renderTo:'spProcolo',
                                                                frame:false,
                                                                width:880,
                                                                height:450,
                                                                sm:chkRow,
                                                                cm: cModelo,
                                                                clicksToEdit:1,
                                                                plugins:	[checkColumn],
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,   
                                                                tbar:	[
                                                                			{
                                                                                icon:'../images/guardar.JPG',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:(gE('situacionInforme').value=='1'),
                                                                                text:'Guardar',
                                                                                handler:function()
                                                                                        {
                                                                                        	guardarDatosResolutivos();
                                                                                            
                                                                                        }
                                                                                
                                                                            },'-',
                                                                             {
                                                                                  id:'btnFinalizar',
                                                                                  icon:'../images/icon_big_tick.gif',
                                                                                  cls:'x-btn-text-icon',
                                                                                  hidden:(gE('situacionInforme').value=='1'),
                                                                                  text:'Finalizar informe',
                                                                                  handler:function()
                                                                                          {
                                                                                               function resp(btn)
                                                                                               {
                                                                                               		if(btn=='yes')
                                                                                                    {
                                                                                                    	guardarDatosResolutivos(finalizarInforme);
                                                                                                    }
                                                                                               }
                                                                                               msgConfirm('Est&aacute; seguro de querer finalizar el registro del protocolo?',resp);
                                                                                          }
                                                                                  
                                                                              },'-',
                                                                              {
	                                                                              	xtype:'label',
                                                                                    html:'<b>Hora de inicio de la audiencia: </b>'+gE('horaInicio').value+ ' hrs.'
                                                                              },'-',
                                                                              {
                                                                              		xtype:'label',
                                                                                    hidden:(gE('videoDisponible').value==''),
                                                                                    html:'Se encuentra disponible el video de la audiencia, para verlo de click <a href="javascript:mostrarVideo()"><span style="color:#F00"><b>AQU&Iacute;</b></span></a>'
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
        
        
        tblGrid.on('beforeedit',function(e)
    						{
                            	if(gE('situacionInforme').value=='1')
                                {
                                	e.cancel=true;
                                    return;
                                }
                                
                            	if(e.field!='realizado')
                                {
                                	
                                    if(!e.record.data.realizado)
                                        e.cancel=true;
                                   
                                    
                                }
                                else
                                {
                                	
                                	if(e.value)//(gE('situacionInforme').value=='0')
                                    {
                                    	e.record.set('horaRealizacion','');
                                        e.record.set('segundosRealizacion','');
                                        e.record.set('comentariosAdicionales','');
                                        
                                    }
                                    else
                                    {
                                    	if(e.record.get('horaRealizacion')=='')
                                        {
                                        	var x=e.row;
                                            var fila;
                                            var ultimaHora=gE('horaInicio').value;
                                            for(nReg=(x-1);nReg>=0;nReg--)
                                            {
                                            	fila=e.grid.getStore().getAt(nReg);
                                                if(fila.data.realizado)
                                                {
                                                	ultimaHora=fila.data.horaRealizacion;
                                                    break;
                                                }
                                            }
	                                    	e.record.set('horaRealizacion',ultimaHora);
                                        }
                                    }
                                }
                                
                            	
                            }
    			)  
        return 	tblGrid;
     
}

function guardarDatosResolutivos(funcionEjecutar)
{
	var tblGrid=gEx('gProcolo');
	var arrDatosProtocolo='';
    var fila;
    var x;
    for(x=0;x<tblGrid.getStore().getCount();x++)
    {
        fila=tblGrid.getStore().getAt(x);
        if(fila.data.realizado)
        {
        	o='{"llave":"'+fila.data.llave+'","protocolo":"'+fila.data.protocolo+'","horaRealizacion":"'+(fila.data.horaRealizacion+':'+((fila.data.segundosRealizacion=='')?'00':fila.data.segundosRealizacion))+'","comentariosAdicionales":"'+cv(fila.data.comentariosAdicionales)+'"}';
            if(arrDatosProtocolo=='')
                arrDatosProtocolo=o;
             else
                arrDatosProtocolo+=','+o;
        }
    }
    
    
    var obj='{"idEvento":"'+gE('idEvento').value+'","registros":['+arrDatosProtocolo+']}';
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	if(!funcionEjecutar)
            {
                msgBox('La informaci&oacute;n ha sido almacenada correctamente');
                return;
            }
            else
            {
            	funcionEjecutar();
            }
                
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=85&cadObj='+obj,true);
    
    
}

function finalizarInforme()
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            recargarPagina();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=86&idEvento='+gE('idEvento').value,true);
}

function mostrarVideo()
{
	gE('myVideo').src=gE('videoDisponible').value;
    gE('myVideo').play();
    mE('spVideo');
}