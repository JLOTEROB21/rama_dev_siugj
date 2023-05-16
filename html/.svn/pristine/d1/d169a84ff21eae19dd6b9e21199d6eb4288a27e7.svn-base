<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$idEvento=$_GET["iE"];
	
	$consulta="SELECT valor,texto FROM 1004_siNo";
	$arrSiNo=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT carpetaAdministrativa  FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 AND idRegistroContenidoReferencia=".$idEvento;
	$cAdministrativa=$con->obtenerValor($consulta);
	
	
	$consulta="SELECT horaInicioEvento FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$idEvento;
	$horaEvento=$con->obtenerValor($consulta);
	
	
	
	$consulta="SELECT e.idRegistroEvento,horaInicioEvento FROM 7007_contenidosCarpetaAdministrativa c,7000_eventosAudiencia e
				WHERE carpetaAdministrativa='".$cAdministrativa."' AND tipoContenido=3 AND idRegistroContenidoReferencia<>".$idEvento."
				AND e.idRegistroEvento=c.idRegistroContenidoReferencia AND e.situacion NOT IN (3,6)
				and horaInicioEvento>='".$horaEvento."'";
	
	$arrAudiencias="";
	$resAudiencias=$con->obtenerFilas($consulta);				
	while($fAudiencias=mysql_fetch_row($resAudiencias))
	{
		$o="['".$fAudiencias[0]."','(".$fAudiencias[0].") ".date("d/m/Y H:i",strtotime($fAudiencias[1]))."']";
		if($arrAudiencias=="")
			$arrAudiencias=$o;
		else
			$arrAudiencias.=",".$o;
	}
	
	$consulta="SELECT e.idRegistroEvento,horaInicioEvento FROM 7007_contenidosCarpetaAdministrativa c,7000_eventosAudiencia e
				WHERE carpetaAdministrativa='".$cAdministrativa."' AND tipoContenido=3 AND idRegistroContenidoReferencia<>".$idEvento."
				AND e.idRegistroEvento=c.idRegistroContenidoReferencia AND e.situacion NOT IN (3,6)
				and horaInicioEvento>='".$horaEvento."'";
				
	$arrTotalAudiencia="";			
	
	
	
	$resAudiencias=$con->obtenerFilas($consulta);				
	while($fAudiencias=mysql_fetch_row($resAudiencias))
	{
		$o="['".$fAudiencias[0]."','(".$fAudiencias[0].") ".date("d/m/Y H:i",strtotime($fAudiencias[1]))."']";
		if($arrTotalAudiencia=="")
			$arrTotalAudiencia=$o;
		else
			$arrTotalAudiencia.=",".$o;
	}
	
				
	
	$consulta="SELECT unidadGestion,idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cAdministrativa."'";
	$fDatosCarpeta=$con->obtenerPrimeraFila($consulta);
	$unidadGestion=$fDatosCarpeta[0];
	$idActividad=$fDatosCarpeta[1];
	
	$consulta="SELECT carpetaAdministrativa,carpetaAdministrativa FROM 7006_carpetasAdministrativas 
				WHERE unidadGestion='".$unidadGestion."'";//."' and carpetaAdministrativa<>'".$cAdministrativa."'"
	$arrCarpetasAdministrativas=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT id__110_tablaDinamica,tipoMedidaCautelar FROM _110_tablaDinamica ORDER BY tipoMedidaCautelar";
	$arrMedidasCautelares=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__47_tablaDinamica,CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno)
				,' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno)) AS nombre FROM 7005_relacionFigurasJuridicasSolicitud r,
				_47_tablaDinamica p WHERE r.idActividad=".$idActividad." AND r.idFiguraJuridica=4 
				AND p.id__47_tablaDinamica=r.idParticipante";

	$arrImputados=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__328_tablaDinamica,nombreAutoridad FROM _328_tablaDinamica";
	$arrAutoridad=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT id__333_tablaDinamica,medidaProteccion FROM _333_tablaDinamica ORDER BY medidaProteccion";
	$arrMedidasProteccion=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT id__334_tablaDinamica,nombreCondicion FROM _334_tablaDinamica ORDER BY nombreCondicion";
	$arrSuspencionCondicional=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT * FROM 3014_registroAcuerdosReparatorios WHERE idEvento=".$idEvento;
	$arrAcuerdo=$con->obtenerFilasArreglo($consulta);
	
?>

var fechaEvento='<?php echo date("Y-m-d",strtotime($horaEvento))?>';
var arrAutoridad=<?php echo $arrAutoridad?>;
var arrImputados=<?php echo $arrImputados?>;
var arrMedidasCautelares=<?php echo $arrMedidasCautelares?>;
var arrMedidasProteccion=<?php echo $arrMedidasProteccion?>;
var arrSuspencionCondicional=<?php echo $arrSuspencionCondicional?>;

var arrTotalAudiencia=[<?php echo $arrTotalAudiencia?>];
var arrAudiencias=[<?php echo $arrAudiencias?>];
var arrCarpetasAdministrativas=<?php echo $arrCarpetasAdministrativas?>;
var arrSiNo=<?php echo $arrSiNo?>;
var arrTipoCumplimiento=[['1','Inmediato'],['2','Diferido']];


var arrAcuerdo=<?php echo $arrAcuerdo?>;


var sLectura=false;

Ext.onReady(inicializar);

function inicializar()
{
	sLectura=gE('situacionInforme').value=='1';
	
	arrImputados.splice(1,0,['0','Registrar imputado']);
	loadScript('../modulosEspeciales_SGJP/Scripts/controlEventos.js.php', function()
    																		{
                                                                            	var objConf={};
                                                                                objConf.idEvento=gE('idEvento').value;
                                                                                objConf.renderTo='tblAudiencia';
                                                                                objConf.permiteModificarTipoAudiencia=(gE('situacionInforme').value=='1')?false:true;
                                                                                objConf.permiteModificarHorarioDesarrollo=(gE('situacionInforme').value=='1')?false:true;
                                                                                objConf.mostrarDesarrollo=true;
                                                                                objConf.permiteModificarEdificio=false;  
                                                                                objConf.permiteModificarUnidadGestion=false;  
                                                                                objConf.permiteModificarSala=false;  
                                                                                objConf.permiteModificarFecha=false;    
                                                                                objConf.permiteModificarJuez=false;                                                                               
                                                                                objConf.mostrarFechaAudiencia=true;
                                                                                objConf.mostrarTipoAudiencia=true;
                                                                                objConf.mostrarDuracionAudiencia=true;
                                                                                objConf.mostrarSalaAudiencia=true;
                                                                                objConf.mostrarCentroGestion=true;
                                                                                objConf.mostrarEdificio=true;
                                                                                objConf.mostrarJueces=true;
                                                                                objConf.mostrarDuracionDesarrollo=false;
                                                                                objConf.mostrarHorarioDesarrollo=true;
                                                                                objConf.mostrarDocumentoMultimedia=false;
                                                                            	construirTableroEvento(objConf);
                                                                            }
			)   
            
            
	new Ext.TabPanel	(
    						{
                            	renderTo:'tblResolutivos',
                                id:'tpResolutivos',
                                width:960,
                                height:600,
                                border:true,
                                plain:true,
                                
                                activeTab:0,
                                tbar:	[

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
                                                                	guardarInforme(finalizarInforme);
                                                            }
                                                            msgConfirm('Est&aacute; seguro de querer finalizar el registro de resolutivos?',resp); 
                                                      }
                                              
                                          }
                                		],
                                items:	[
                                			crearGridAccionesResolutivos(),
                                            crearGridAcuerdosReparatorios(),
                                            crearGridMedidasCautelares(),
                                            crearGridMedidasProteccion(),
                                            crearGridCondicionesSuspension()
                                            
                                		]
                            }
    					)            
                                                                                     

	
    
    if(sLectura)
    {
    	desHabilitarAcuerdo();
    }
    
}

function crearGridAccionesResolutivos()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idResolutivo'},
                                                        {name:'aplicado'},
		                                                {name: 'resolutivo'},
                                                        {name: 'tipoValor'},
		                                                {name:'valor'},
                                                        {name:'prioridad'},
                                                        {name: 'comentariosAdicionales'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 

	var checkColumn = new Ext.grid.CheckColumn	(
	 												{
													   header: '',
													   dataIndex: 'aplicado',
													   width: 40
													}
												);
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_SGP.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'prioridad', direction: 'ASC'},
                                                            groupField: 'prioridad',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='63';
                                        proxy.baseParams.iE=gE('idEvento').value;
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:30}),
                                                            checkColumn,
                                                            {
                                                                header:'Accion/Resolutivo',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'resolutivo'
                                                            },
                                                            {
                                                                header:'Valor',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'valor',
                                                                editor:{xtype:'textfield'},
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	
                                                                        	switch(registro.data.tipoValor)
                                                                            {
                                                                            	case '1':
                                                                                	return formatearValorRenderer(arrSiNo,val);	
                                                                                break;
                                                                                case '2':
                                                                                	if(!registro.data.aplicado)
                                                                                    	return;
                                                                                
                                                                                	var comp='';
                                                                                	if(val!='')
                                                                                    {
                                                                                    	
                                                                                        var oVal=eval('['+val+']')[0];
                                                                                        comp=' ('+oVal.anios+'|'+oVal.meses+'|'+oVal.dias+'):'+Date.parseDate(oVal.fechaFinal,'Y-m-d').format('d/m/Y');
                                                                                    }
                                                                                    if(gE('situacionInforme').value=='1')
                                                                                    {
                                                                                    	return comp;	
                                                                                    }
                                                                                    else
	                                                                                	return '<a href="javascript:registrarPeriodo(\''+bE(registro.data.idResolutivo)+'\')"><img src="../images/pencil.png" width="13" height="13" /></a>'+comp;	
                                                                                break;
                                                                                case '3':
                                                                                	return formatearValorRenderer(arrTotalAudiencia,val);		
                                                                                break;
                                                                                case '4':
                                                                                	if(val!='')
                                                                                    {
                                                                                    	if(val.format)
                                                                                        	return val.format('d/m/Y');
                                                                                     	return Date.parseDate(val,'Y-m-d').format('d/m/Y');	
                                                                                    }
                                                                                break;
                                                                                case '5':
                                                                                	return Ext.util.Format.number(val,'0.00');	
                                                                                break;
                                                                                case '6':
                                                                                	return val;	
                                                                                break;
                                                                                case '7':
                                                                                	return 'N/A';	
                                                                                break;
                                                                                case '8':
                                                                                	var lblImputados='';
                                                                                    var aImputados=val.split(',');
                                                                                    var x;
                                                                                    for(x=0;x<aImputados.length;x++)
                                                                                    {
                                                                                    	if(lblImputados=='')
                                                                                        	lblImputados=formatearValorRenderer(arrImputados,aImputados[x]);
                                                                                        else
                                                                                        	lblImputados+='<br>'+formatearValorRenderer(arrImputados,aImputados[x]);
                                                                                    }
                                                                                
                                                                                	return lblImputados;	
                                                                                break;
                                                                                
                                                                            }
                                                                        	
                                                                            	
                                                                        }
                                                            },
                                                            {
                                                                header:'Comentarios adicionales',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'comentariosAdicionales',
                                                                editor:{xtype:'textarea'},
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.replace(/\n/gi,'<br />');
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                            {
                                                                id:'gridResolutivos',
                                                                store:alDatos,
                                                                title:'Acciones/resolutivos',
                                                                region:'center',
                                                                frame:false,
                                                                clicksToEdit:1,
                                                                cm: cModelo,
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                plugins:[checkColumn],
                                                                columnLines : false,     
                                                                tbar:	[
                                                                			{
                                                                                icon:'../images/guardar.JPG',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:(gE('situacionInforme').value=='1'),
                                                                                text:'Guardar informe',
                                                                                handler:function()
                                                                                        {
                                                                                        	guardarInforme();
                                                                                            
                                                                                            
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
                                                        
	tblGrid.on('beforeedit',function(e)
    						{
                            	if(gE('situacionInforme').value=='1')
                                {
                                	e.cancel=true;
                                }
                                
                                if((e.record.data.tipoValor=='2')&&(e.field=='valor'))
                                {
                                	e.cancel=true;
                                }
                                
                            	if(e.field!='aplicado')
                                {
                                	
                                    if(!e.record.data.aplicado)
                                        e.cancel=true;
                                   	

                                    var control=new Ext.form.TextField({});
                                    if(e.field=='valor')
                                    {
                                    	
                                    	switch(e.record.data.tipoValor)
                                        {
                                        	case '1': //Valor Si/No
												control=crearComboExt('cmbSiNo',arrSiNo,0,0);
                                            break;
                                            case '2': //Valor periodo de tiempo
												
                                            break;
                                            case '3': //Vinculacion con audiencia
												control=crearComboExt('cmbAudiencia',arrAudiencias,0,0);
                                            break;
                                            case '4': //Valor de fecha--
												control=new Ext.form.DateField({"id":"dteFecha"});
                                            break;
                                            case '5': //Valor numerico
												control=new Ext.form.NumberField({"id":"txtValor","alowDecimals":"true","allowNegatve":"false"});
                                            break;
                                            case '6': //Valor carpeta judicial
												control=crearComboExt('cmbCarpetas',arrCarpetasAdministrativas,0,0);
                                            break;
                                            case '7': //Check box

                                            break;
                                            case '8':
                                            	control=crearComboExt('cmbImputados',arrImputados,0,0,0,{multiSelect:true});
                                            break;
                                        }
                                        
                                        e.grid.getColumnModel().setEditor(3,control);
                                        
                                    }
                                    
                                }
                                else
                                {
                                	
                                	if((e.value)&&(gE('situacionInforme').value=='0'))
                                    {
                                    	e.record.set('valor','');
                                        e.record.set('comentariosAdicionales','');
                                        
                                    }
                                }
                                
                            	
                            }
    			)                                                        
                                                        
        return 	tblGrid;
	
}

function crearGridMedidasCautelares()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistroMedida'},
                                                        {name: 'idEventoAudiencia'},
		                                                {name: 'idMedida'},
		                                                {name:'idImputado'},
                                                        {name: 'comentariosAdicionales'},
                                                        {name: 'valorComp1'},
                                                        {name: 'valorComp2'},
                                                        {name: 'valorComp3'}
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
                                                            sortInfo: {field: 'idMedida', direction: 'ASC'},
                                                            groupField: 'idImputado',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	gEx('btnMedidaCautelarDel').disable();
                                        gEx('btnMedidaCautelarMod').disable();
                                    	proxy.baseParams.funcion='67';
                                        proxy.baseParams.idEvento=gE('idEvento').value;
                                        proxy.baseParams.idActividad=gE('idActividad').value;
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'idEventoAudiencia',
                                                                renderer:function(val)
                                                                		{
                                                                        	if((val==gE('idEvento').value)&&(gE('situacionInforme').value=='0'))
                                                                            {
                                                                            	
                                                                            }
                                                                            else
                                                                            {
                                                                            	return '<img src="../images/lock.png">';
                                                                            }
                                                                        }
                                                            },
                                                            {
                                                                header:'Medida cautelar',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'idMedida',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrMedidasCautelares,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Imputado',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'idImputado',
                                                                renderer:function(val)
                                                                		{
                                                                        	return "Imputado: "+formatearValorRenderer(arrImputados,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Detalle',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'valorComp1',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	switch(registro.data.idMedida)
                                                                            {
                                                                            	case '1':
                                                                                	return 'Presentarse ante autoridad: '+formatearValorRenderer(arrAutoridad,val);
                                                                                break;
                                                                                case '2':
                                                                                	return 'Monto de la garant&iacute;a: '+Ext.util.Format.usMoney(val)+' ('+registro.data.valorComp2+' '+((registro.data.valorComp2=='1')?'Pago':'Pagos')+')';
                                                                                break;
                                                                                default:
                                                                                	return mostrarValorDescripcion(registro.data.comentariosAdicionales)
                                                                                break;
                                                                            }
                                                                        }
                                                            },
                                                            {
                                                                header:'Comentarios adicionales',
                                                                width:500,
                                                                sortable:true,
                                                                dataIndex:'comentariosAdicionales',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	switch(registro.data.idMedida)
                                                                            {
                                                                            	case '1':
                                                                                case '2':
                                                                                	return mostrarValorDescripcion(val);
                                                                                break;
                                                                                default:
                                                                                	return '';
                                                                                break;
                                                                            }
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridMedida',
                                                                store:alDatos,
                                                                region:'center',
                                                                title:'Medidas cautelares',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true, 
                                                                tbar:	[
                                                                			{
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:(gE('situacionInforme').value=='1'),
                                                                                text:'Agregar medida cautelar',
                                                                                handler:function()
                                                                                        {
                                                                                            mostrarVentanaMedidaCautelar();
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                            	id:'btnMedidaCautelarDel',
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                disabled:true,
                                                                                hidden:(gE('situacionInforme').value=='1'),
                                                                                text:'Remover medida cautelar',
                                                                                handler:function()
                                                                                        {
                                                                                        	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar la medida cautelar a remover');
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
                                                                                                                gEx('gridMedida').getStore().reload(); 
                                                                                                                
                                                                                                            }
                                                                                                            else
                                                                                                            {
                                                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                            }
                                                                                                        }
                                                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=68&idMedida='+fila.data.idRegistroMedida,true);
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer remover la medida cautelar seleccionada?',resp);

                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                            	id:'btnMedidaCautelarMod',
                                                                                icon:'../images/pencil.png',
                                                                                cls:'x-btn-text-icon',
                                                                                disabled:true,
                                                                                hidden:(gE('situacionInforme').value=='1'),
                                                                                text:'Modificar medida cautelar',
                                                                                handler:function()
                                                                                        {
																							var fila=tblGrid.getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar la medida cautelar a modificar');
                                                                                                return;
                                                                                            }
                                                                                            
                                                                                            mostrarVentanaMedidaCautelar(fila);
                                                                                            
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
                                                        
	tblGrid.getSelectionModel().on('rowselect',function(grid,nFila,registro)
    											{
                                                	gEx('btnMedidaCautelarDel').disable();
			                                        gEx('btnMedidaCautelarMod').disable();
                                                    
                                                    if(registro.data.idEventoAudiencia==gE('idEvento').value)
                                                    {
                                                    	gEx('btnMedidaCautelarDel').enable();
				                                        gEx('btnMedidaCautelarMod').enable();
                                                    }
                                                    
                                                }
    
    								)                                                        	
                                                        
        return 	tblGrid;
}

function registrarPeriodo(iR)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	xtype:'label',
                                                            html:'Fecha base:',
                                                            x:10,
                                                            y:10
                                                        },
														{
                                                        	xtype:'datefield',
                                                            id:'dteFechaBase',
                                                            x:130,
                                                            y:5,
                                                            value:fechaEvento,
                                                            listeners:	{	
                                                            				select:function(ctr)	
                                                                            		{
                                                                                    	calcularFechaFinal()
                                                                                    }
                                                            			}
                                                        },
                                                        {
                                                        	xtype:'label',
                                                            html:'A&ntilde;os:',
                                                            x:10,
                                                            y:40
                                                        },
                                                        {
                                                        	x:130,
                                                            y:35,
                                                        	xtype:'numberfield',
                                                            width:60,
                                                            id:'txtAnos',
                                                            allowDecimals:true,
                                                            allowNegative:false,
                                                            value:0,
                                                            listeners:	{	
                                                            				change:function(ctr)	
                                                                            		{
                                                                                    	calcularFechaFinal()
                                                                                    }
                                                            			}
                                                        },
                                                        {
                                                        	xtype:'label',
                                                            html:'Meses:',
                                                            x:10,
                                                            y:70
                                                        },
                                                        {
                                                        	x:130,
                                                            y:65,
                                                        	xtype:'numberfield',
                                                            width:60,
                                                            id:'txtMeses',
                                                            allowDecimals:true,
                                                            allowNegative:false,
                                                            value:0,
                                                            listeners:	{	
                                                            				change:function(ctr)	
                                                                            		{
                                                                                    	calcularFechaFinal()
                                                                                    }
                                                            			}
                                                        },
                                                        {
                                                        	xtype:'label',
                                                            html:'D&iacute;as:',
                                                            x:10,
                                                            y:100
                                                        },
                                                        {
                                                        	x:130,
                                                            y:95,
                                                        	xtype:'numberfield',
                                                            width:60,
                                                            id:'txtDias',
                                                            allowDecimals:true,
                                                            allowNegative:false,
                                                            value:0,
                                                            listeners:	{	
                                                            				change:function(ctr)	
                                                                            		{
                                                                                    	calcularFechaFinal()
                                                                                    }
                                                            			}
                                                        },
                                                        {
                                                        	xtype:'label',
                                                            html:'Fecha resultado:',
                                                            x:10,
                                                            y:130
                                                        },
                                                        {
                                                        	xtype:'datefield',
                                                            id:'txtFechaResultado',
                                                            x:130,
                                                            y:125,
                                                            disabled:true,
                                                            value:fechaEvento
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Definir periodo',
										width: 500,
										height:250,
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
																		var cadObj='{"fechaBase":"'+gEx('dteFechaBase').getValue().format('Y-m-d')+
                                                                                    '","anios":"'+gEx('txtAnos').getValue()+'","meses":"'+gEx('txtMeses').getValue()+
                                                                                    '","dias":"'+gEx('txtDias').getValue()+'","fechaFinal":"'+
                                                                                    gEx('txtFechaResultado').getValue().format('Y-m-d')+'"}';
                                                                        
                                                                        
                                                                        var pos=obtenerPosFila(gEx('gridResolutivos').getStore(),'idResolutivo',bD(iR));
                                                                        var fila=gEx('gridResolutivos').getStore().getAt(pos);
                                                                        
                                                                        fila.set('valor',cadObj);
                                                                        
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

function calcularFechaFinal()
{
	var fechaFinal=gEx('dteFechaBase').getValue();
	var txtAnos=gEx('txtAnos');
    if(txtAnos.getValue()=='')
	   	txtAnos.setValue(0);
    
    var txtMeses=gEx('txtMeses');
    if(txtMeses.getValue()=='')
	   	txtMeses.setValue(0);
        
    var txtDias=gEx('txtDias');
    if(txtDias.getValue()=='')
	   	txtDias.setValue(0); 
    
    
    if(txtAnos.getValue()>0)
    {
    	fechaFinal=fechaFinal.add(Date.YEAR,txtAnos.getValue());
    }
    
    if(txtMeses.getValue()>0)
    {
    	fechaFinal=fechaFinal.add(Date.MONTH,txtMeses.getValue());
    }
    
    if(txtDias.getValue()>0)
    {
    	fechaFinal=fechaFinal.add(Date.DAY,txtDias.getValue());
    }
    
    
    gEx('txtFechaResultado').setValue(fechaFinal);
}

function mostrarVentanaMedidaCautelar(filaRegistro)
{
	var cmbAutoridad=crearComboExt('cmbAutoridad',arrAutoridad,240,5,250);
	var cmbImputado=crearComboExt('cmbImputado',arrImputados,110,5,300);
    if(arrImputados.length==1)
    {
    	cmbImputado.setValue(arrImputados[0][0]);
    }
	var cmbMedidaCautelar=crearComboExt('cmbMedidaCautelar',arrMedidasCautelares,110,35,500);
    
    cmbMedidaCautelar.on('select',function(cmb,registro)
    								{
                                    	gEx('flGarantiaEconomica').hide();
                                        gEx('fieldGeneral').hide();
                                        gEx('fieldPresentacionPeriodica').hide();                                        
                                        gEx('txtMontoGarantia').setValue('');
                                        gEx('txtNoPagos').setValue('');
                                        gEx('txtComentarios').setValue('');
                                        gEx('txtComentarios2').setValue('');
                                        gEx('cmbAutoridad').setValue('');
                                        gEx('txtComentarios2').setValue('');
                                        
                                    	switch(registro.data.id)
                                        {
                                        	case '2': //Presentación garantia
                                            	gEx('flGarantiaEconomica').show();
                                                gEx('txtMontoGarantia').focus(false,500);
                                            	
                                            break;
                                            case '1': //Presentación periodica
                                            	gEx('fieldPresentacionPeriodica').show();
                                                gEx('cmbAutoridad').focus(false,500);
                                            break;
                                            default:
                                            	gEx('fieldGeneral').show();
                                                gEx('txtComentarios2').focus(false,500);
                                            break;
                                        }
                                    	
                                        gEx('vMedida').setHeight(380);
                                    }
    					)
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',                                            
											items: 	[
                                            			{
                                                        	xtype:'label',
                                                            html:'Imputado:',
                                                            x:10,
                                                            y:10
                                                        },
                                                        cmbImputado,
                                            			{
                                                        	xtype:'label',
                                                            html:'Medida cautelar:',
                                                            x:10,
                                                            y:40
                                                        },
                                                        cmbMedidaCautelar,
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            hidden:true,
                                                            id:'flGarantiaEconomica',
                                                        	xtype:'fieldset',
                                                            width:600,
                                                            height:220,
                                                            layout:'absolute',
                                                            title:'Detalles adicionales',
                                                            items:	[
                                                            			{
                                                                        	x:10,
                                                                            y:10,
                                                                        	xtype:'label',
                                                                            html:'Monto de la garantía:'
                                                                        },
                                                                        {
                                                                        	id:'txtMontoGarantia',
                                                                        	x:150,
                                                                            y:5,
                                                                            width:80,
                                                                            xtype:'numberfield',
                                                                            allowDecimals:true,
                                                                            allowNegative:false,
                                                                            listeners:	{
                                                                            				change:function(ctrl)
                                                                                            		{
                                                                                                    	gE('lblMontoFormato').innerHTML=Ext.util.Format.usMoney(ctrl.getValue());
                                                                                                    }
                                                                            			}
                                                                        },
                                                                        {
                                                                        	x:250,
                                                                            y:10,
                                                                        	xtype:'label',
                                                                            html:'<span id="lblMontoFormato">$ 0.00</span>'
                                                                        },
                                                                        {
                                                                        	x:10,
                                                                            y:40,
                                                                        	xtype:'label',
                                                                            html:'N&uacute;mero de pagos:'
                                                                        },
                                                                        {
                                                                        	id:'txtNoPagos',
                                                                        	x:150,
                                                                            y:35,
                                                                            width:40,
                                                                            xtype:'numberfield',
                                                                            allowDecimals:false,
                                                                            allowNegative:false
                                                                        },
                                                                        {
                                                                        	x:10,
                                                                            y:70,
                                                                        	xtype:'label',
                                                                            html:'Comentarios adicionales:'
                                                                        },
                                                                        {
                                                                        	x:10,
                                                                            y:100,
                                                                            width:560,
                                                                            height:80,
                                                                            xtype:'textarea',
                                                                            id:'txtComentarios'
                                                                        }
                                                            		]
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            id:'fieldGeneral',
                                                        	xtype:'fieldset',
                                                            width:600,
                                                            height:180,
                                                            hidden:true,
                                                            layout:'absolute',
                                                            title:'Detalles adicionales',
                                                            items:	[
                                                            			
                                                                        {
                                                                        	x:10,
                                                                            y:10,
                                                                        	xtype:'label',
                                                                            html:'Especificaciones de la medida cautelar:'
                                                                        },
                                                                        {
                                                                        	x:10,
                                                                            y:40,
                                                                            width:560,
                                                                            height:80,
                                                                            xtype:'textarea',
                                                                            id:'txtComentarios2'
                                                                        }
                                                            		]
                                                        },
                                                         {
                                                        	x:10,
                                                            y:70,
                                                            id:'fieldPresentacionPeriodica',
                                                        	xtype:'fieldset',
                                                            width:600,
                                                            hidden:true,
                                                            height:190,
                                                            layout:'absolute',
                                                            title:'Detalles adicionales',
                                                            items:	[
                                                            			
                                                                        {
                                                                        	x:10,
                                                                            y:5,
                                                                            xtype:'label',
                                                                            html:'Autoridad a la que deber&aacute; presentarse:'
                                                                        },
                                                                        cmbAutoridad,
                                                                        
                                                                        {
                                                                        	x:10,
                                                                            y:35,
                                                                        	xtype:'label',
                                                                            html:'Especificaciones adicionales:'
                                                                        },
                                                                        {
                                                                        	x:10,
                                                                            y:65,
                                                                            width:560,
                                                                            height:80,
                                                                            xtype:'textarea',
                                                                            id:'txtComentarios3'
                                                                        }
                                                            		]
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Registro de medida cautelar',
										width: 650,
										height:190,
                                        id:'vMedida',
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
                                                                    
                                                                    	var existeRegistro=false;
                                                                        var x;
                                                                        var fila;
                                                                        
                                                                    
                                                                    
                                                                    	if(cmbImputado.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	cmbImputado.fcous();
                                                                            }
                                                                            msgBox('Debe indicar el imputado al cual se aplica la medida cautelar',resp1);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(cmbMedidaCautelar.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbImputado.fcous();
                                                                            }
                                                                            msgBox('Debe indicar la medida cautelar aplicada',resp2);
                                                                            return;
                                                                        }
                                                                        
                                                                        
                                                                        for(x=0;x<gEx('gridMedida').getStore().getCount();x++)
                                                                        {
                                                                        	fila=gEx('gridMedida').getStore().getAt(x);
                                                                            if((fila.data.idMedida==cmbMedidaCautelar.getValue())&&(fila.data.idImputado==cmbImputado.getValue()))
                                                                            {

                                                                            	if((!filaRegistro)||(fila.data.idRegistroMedida!=filaRegistro.data.idRegistroMedida))
                                                                            	{
                                                                            		msgBox('Esta medida ya ha sido aplicada al imputado');
                                                                            		return;
                                                                               	}
                                                                            }
                                                                        }
                                                                        
                                                                    	var datosMedida='{"idRegistroMedida":"'+((filaRegistro)?filaRegistro.data.idRegistroMedida:-1)+'","idMedida":"'+cmbMedidaCautelar.getValue()+'",';
																		switch(cmbMedidaCautelar.getValue())
                                                                        {
                                                                            case '2': //Presentación garantia
                                                                            	var txtMontoGarantia=gEx('txtMontoGarantia');
                                                                                var txtNoPagos=gEx('txtNoPagos');
                                                                                
                                                                                if(txtMontoGarantia.getValue()=='')
                                                                                {
                                                                                	function resp10()
                                                                                    {
                                                                                    	txtMontoGarantia.focus();
                                                                                    }
                                                                                    msgBox('Debe ingresar el monto de la garant&iacute;a',resp10);
                                                                                    return;
                                                                                }
                                                                                
                                                                                if(txtNoPagos.getValue()=='')
                                                                                {
                                                                                	function resp11()
                                                                                    {
                                                                                    	txtNoPagos.focus();
                                                                                    }
                                                                                    msgBox('Debe ingresar el n&uacute;mero de pagos en que ser&aacute; cubierta la garant&iacute;a',resp11);
                                                                                    return;
                                                                                }
                                                                                
                                                                              	  
                                                                                datosMedida+='"montoGarantia":"'+txtMontoGarantia.getValue()+'","noPagos":"'+txtNoPagos.getValue()+
                                                                                			'","comentariosAdicionales":"'+cv(gEx('txtComentarios').getValue())+'"}';
                                                                                
                                                                            break;
                                                                            case '1': //Presentación periodica
                                                                            
                                                                            		if(cmbAutoridad.getValue()=='')
                                                                                    {
                                                                                    	function resp20()
                                                                                        {
                                                                                        	cmbAutoridad.focus();
                                                                                        }
                                                                                        msgBox('Debe indicar la autoridad a la cual de deber&aacute; presentarse el imputado',resp20);
                                                                                        return;
                                                                                    }
                                                                            
                                                                                 datosMedida+='"autoridad":"'+cmbAutoridad.getValue()+'","comentariosAdicionales":"'+
                                                                                 			cv(gEx('txtComentarios3').getValue())+'"}';
                                                                            break;
                                                                            default:
                                                                               	datosMedida+='"comentariosAdicionales":"'+cv(gEx('txtComentarios2').getValue())+'"}';
                                                                            break;
                                                                        }
                                                                        
                                                                        
                                                                        var cadObj='{"idActividad":"'+gE('idActividad').value+'","idEvento":"'+gE('idEvento').value+'","idImputado":"'+cmbImputado.getValue()+'","datosMedida":'+datosMedida+'}';
                                                                        
                                                                       	function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                             	gEx('gridMedida').getStore().reload(); 
                                                                                ventanaAM.close();  
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=66&cadObj='+cadObj,true);
                                                                        
                                                                        
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
    
    if(filaRegistro)
    {
    	cmbImputado.setValue(filaRegistro.data.idImputado);
        cmbMedidaCautelar.setValue(filaRegistro.data.idMedida);
        dispararEventoSelectCombo('cmbMedidaCautelar');
        switch(filaRegistro.data.idMedida)
        {
        	case '1':
            	cmbAutoridad.setValue(filaRegistro.data.valorComp1);
            	gEx('txtComentarios3').setValue(escaparBR(filaRegistro.data.comentariosAdicionales,true));
            break;
            case '2':
            	gEx('txtMontoGarantia').setValue(filaRegistro.data.valorComp1);
                gEx('txtNoPagos').setValue(filaRegistro.data.valorComp2);
            	gEx('txtComentarios').setValue(escaparBR(filaRegistro.data.comentariosAdicionales,true));
            break;
            default:
            	gEx('txtComentarios2').setValue(escaparBR(filaRegistro.data.comentariosAdicionales,true));
            break;
        }
    }
    		
}

function crearGridMedidasProteccion()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistroMedida'},
                                                        {name: 'idEventoAudiencia'},
		                                                {name: 'idMedida'},
		                                                {name:'idImputado'},
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
                                                            sortInfo: {field: 'idMedida', direction: 'ASC'},
                                                            groupField: 'idImputado',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	gEx('btnMedidaProteccionDel').disable();
                                        gEx('btnMedidaProteccionMod').disable();
                                    	proxy.baseParams.funcion='74';
                                        proxy.baseParams.idEvento=gE('idEvento').value;
                                        proxy.baseParams.idActividad=gE('idActividad').value;
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'idEventoAudiencia',
                                                                renderer:function(val)
                                                                		{
                                                                        	if((val==gE('idEvento').value)&&(gE('situacionInforme').value=='0'))
                                                                            {
                                                                            	
                                                                            }
                                                                            else
                                                                            {
                                                                            	return '<img src="../images/lock.png">';
                                                                            }
                                                                        }
                                                            },
                                                            {
                                                                header:'Medida de protecci&oacute;n',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'idMedida',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrMedidasProteccion,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Imputado',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'idImputado',
                                                                renderer:function(val)
                                                                		{
                                                                        	return "Imputado: "+formatearValorRenderer(arrImputados,val);
                                                                        }
                                                            },
                                                           
                                                            {
                                                                header:'Comentarios adicionales',
                                                                width:500,
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
                                                                id:'gridMedidaProteccion',
                                                                store:alDatos,
                                                                region:'center',
                                                                title:'Medidas de protecci&oacute;n',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true, 
                                                                tbar:	[
                                                                			{
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:(gE('situacionInforme').value=='1'),
                                                                                text:'Agregar medida de protecci&oacute;n',
                                                                                handler:function()
                                                                                        {
                                                                                            mostrarVentanaMedidaProteccion();
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                            	id:'btnMedidaProteccionDel',
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                disabled:true,
                                                                                hidden:(gE('situacionInforme').value=='1'),
                                                                                text:'Remover medida de protecci&oacute;n',
                                                                                handler:function()
                                                                                        {
                                                                                        	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar la medida protecci&oacute;n a remover');
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
                                                                                                                gEx('gridMedidaProteccion').getStore().reload(); 
                                                                                                                
                                                                                                            }
                                                                                                            else
                                                                                                            {
                                                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                            }
                                                                                                        }
                                                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=78&idMedida='+fila.data.idRegistroMedida,true);
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer remover la medida de protecci&oacute;n seleccionada?',resp);

                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                            	id:'btnMedidaProteccionMod',
                                                                                icon:'../images/pencil.png',
                                                                                cls:'x-btn-text-icon',
                                                                                disabled:true,
                                                                                hidden:(gE('situacionInforme').value=='1'),
                                                                                text:'Modificar medida de protecci&oacute;n',
                                                                                handler:function()
                                                                                        {
																							var fila=tblGrid.getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar la medida de protecci&oacute;n a modificar');
                                                                                                return;
                                                                                            }
                                                                                            
                                                                                            mostrarVentanaMedidaProteccion(fila);
                                                                                            
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
                                                        
	tblGrid.getSelectionModel().on('rowselect',function(grid,nFila,registro)
    											{
                                                	gEx('btnMedidaProteccionDel').disable();
			                                        gEx('btnMedidaProteccionMod').disable();
                                                    
                                                    if(registro.data.idEventoAudiencia==gE('idEvento').value)
                                                    {
                                                    	gEx('btnMedidaProteccionDel').enable();
				                                        gEx('btnMedidaProteccionMod').enable();
                                                    }
                                                    
                                                }
    
    								)                                                        	
                                                        
        return 	tblGrid;
}

function mostrarVentanaMedidaProteccion(filaRegistro)
{
	
	var cmbImputado=crearComboExt('cmbImputado',arrImputados,160,5,300);
    if(arrImputados.length==1)
    {
    	cmbImputado.setValue(arrImputados[0][0]);
    }
	var cmbMedidaProteccion=crearComboExt('cmbMedidaProteccion',arrMedidasProteccion,160,35,450);
    
    cmbMedidaProteccion.on('select',function(cmb,registro)
    								{
                                    	
                                    }
    					)
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',                                            
											items: 	[
                                            			{
                                                        	xtype:'label',
                                                            html:'Imputado:',
                                                            x:10,
                                                            y:10
                                                        },
                                                        cmbImputado,
                                            			{
                                                        	xtype:'label',
                                                            html:'Medida de protecci&oacute;n:',
                                                            x:10,
                                                            y:40
                                                        },
                                                        cmbMedidaProteccion,
                                                        
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            id:'fieldGeneral',
                                                        	xtype:'fieldset',
                                                            width:600,
                                                            height:180,
                                                            layout:'absolute',
                                                            title:'Detalles adicionales',
                                                            items:	[
                                                            			
                                                                        {
                                                                        	x:10,
                                                                            y:10,
                                                                        	xtype:'label',
                                                                            html:'Especificaciones de la medida de protecci&oacute;n:'
                                                                        },
                                                                        {
                                                                        	x:10,
                                                                            y:40,
                                                                            width:560,
                                                                            height:80,
                                                                            xtype:'textarea',
                                                                            id:'txtComentarios'
                                                                        }
                                                            		]
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Registro de medida de protecci&oacute;n',
										width: 650,
										height:330,
                                        id:'vMedida',
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
                                                                    
                                                                    	var existeRegistro=false;
                                                                        var x;
                                                                        var fila;
                                                                        
                                                                    
                                                                    
                                                                    	if(cmbImputado.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	cmbImputado.fcous();
                                                                            }
                                                                            msgBox('Debe indicar el imputado al cual se aplica la medida de protecci&oacute;n',resp1);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(cmbMedidaProteccion.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbImputado.fcous();
                                                                            }
                                                                            msgBox('Debe indicar la medida de protecci&oacute;n',resp2);
                                                                            return;
                                                                        }
                                                                        
                                                                        
                                                                        for(x=0;x<gEx('gridMedidaProteccion').getStore().getCount();x++)
                                                                        {
                                                                        	fila=gEx('gridMedidaProteccion').getStore().getAt(x);
                                                                            if((fila.data.idMedida==cmbMedidaProteccion.getValue())&&(fila.data.idImputado==cmbImputado.getValue()))
                                                                            {

                                                                            	if((!filaRegistro)||(fila.data.idRegistroMedida!=filaRegistro.data.idRegistroMedida))
                                                                            	{
                                                                            		msgBox('La medida de protecci&oacute;n ya ha sido aplicada al imputado');
                                                                            		return;
                                                                               	}
                                                                            }
                                                                        }
                                                                        
                                                                    	var datosMedida='{"idRegistroMedida":"'+((filaRegistro)?filaRegistro.data.idRegistroMedida:-1)+
                                                                        				'","idMedida":"'+cmbMedidaProteccion.getValue()+'","comentariosAdicionales":"'+cv(gEx('txtComentarios').getValue())+
                                                                                        '"}';
                                                                        
                                                                        
                                                                        var cadObj='{"idActividad":"'+gE('idActividad').value+'","idEvento":"'+gE('idEvento').value+'","idImputado":"'+cmbImputado.getValue()+'","datosMedida":'+datosMedida+'}';
                                                                        
                                                                       	function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                             	gEx('gridMedidaProteccion').getStore().reload(); 
                                                                                ventanaAM.close();  
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=76&cadObj='+cadObj,true);
                                                                        
                                                                        
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
    
    if(filaRegistro)
    {
    	cmbImputado.setValue(filaRegistro.data.idImputado);
        cmbMedidaProteccion.setValue(filaRegistro.data.idMedida);
      	gEx('txtComentarios').setValue(escaparBR(filaRegistro.data.comentariosAdicionales,true));
    }
    		
}

function crearGridCondicionesSuspension()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistroMedida'},
                                                        {name: 'idEventoAudiencia'},
		                                                {name: 'idMedida'},
		                                                {name:'idImputado'},
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
                                                            sortInfo: {field: 'idMedida', direction: 'ASC'},
                                                            groupField: 'idImputado',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	gEx('btnSuspensionDel').disable();
                                        gEx('btnSuspensionMod').disable();
                                    	proxy.baseParams.funcion='75';
                                        proxy.baseParams.idEvento=gE('idEvento').value;
                                        proxy.baseParams.idActividad=gE('idActividad').value;
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'idEventoAudiencia',
                                                                renderer:function(val)
                                                                		{
                                                                        	if((val==gE('idEvento').value)&&(gE('situacionInforme').value=='0'))
                                                                            {
                                                                            	
                                                                            }
                                                                            else
                                                                            {
                                                                            	return '<img src="../images/lock.png">';
                                                                            }
                                                                        }
                                                            },
                                                            {
                                                                header:'Condici&oacute;n de suspensi&oacute;n',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'idMedida',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrSuspencionCondicional,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Imputado',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'idImputado',
                                                                renderer:function(val)
                                                                		{
                                                                        	return "Imputado: "+formatearValorRenderer(arrImputados,val);
                                                                        }
                                                            },
                                                           
                                                            {
                                                                header:'Comentarios adicionales',
                                                                width:500,
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
                                                                id:'gridCondicionesSuspension',
                                                                store:alDatos,
                                                                region:'center',
                                                                title:'Condiciones de suspensión de proceso',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true, 
                                                                tbar:	[
                                                                			{
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:(gE('situacionInforme').value=='1'),
                                                                                text:'Agregar condici&oacute;n de suspensi&oacute;n',
                                                                                handler:function()
                                                                                        {
                                                                                            mostrarVentanaCondicionSuspension();
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                            	id:'btnSuspensionDel',
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                disabled:true,
                                                                                hidden:(gE('situacionInforme').value=='1'),
                                                                                text:'Remover condici&oacute;n de suspensi&oacute;n',
                                                                                handler:function()
                                                                                        {
                                                                                        	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar la condici&oacute;n de suspensi&oacute;n a remover');
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
                                                                                                                gEx('gridCondicionesSuspension').getStore().reload(); 
                                                                                                                
                                                                                                            }
                                                                                                            else
                                                                                                            {
                                                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                            }
                                                                                                        }
                                                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=79&idMedida='+fila.data.idRegistroMedida,true);
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer remover la condici&oacute;n de suspensi&oacute;n seleccionada?',resp);

                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                            	id:'btnSuspensionMod',
                                                                                icon:'../images/pencil.png',
                                                                                cls:'x-btn-text-icon',
                                                                                disabled:true,
                                                                                hidden:(gE('situacionInforme').value=='1'),
                                                                                text:'Modificar condici&oacute;n de suspensi&oacute;n',
                                                                                handler:function()
                                                                                        {
																							var fila=tblGrid.getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar la condici&oacute;n de suspensi&oacute;n a modificar');
                                                                                                return;
                                                                                            }
                                                                                            
                                                                                            mostrarVentanaCondicionSuspension(fila);
                                                                                            
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
                                                        
	tblGrid.getSelectionModel().on('rowselect',function(grid,nFila,registro)
    											{
                                                	gEx('btnSuspensionDel').disable();
			                                        gEx('btnSuspensionMod').disable();
                                                    
                                                    if(registro.data.idEventoAudiencia==gE('idEvento').value)
                                                    {
                                                    	gEx('btnSuspensionDel').enable();
				                                        gEx('btnSuspensionMod').enable();
                                                    }
                                                    
                                                }
    
    								)                                                        	
                                                        
        return 	tblGrid;
}

function mostrarVentanaCondicionSuspension(filaRegistro)
{
	
	var cmbImputado=crearComboExt('cmbImputado',arrImputados,160,5,300);
    if(arrImputados.length==1)
    {
    	cmbImputado.setValue(arrImputados[0][0]);
    }
	var cmbMedidaProteccion=crearComboExt('cmbMedidaProteccion',arrSuspencionCondicional,160,35,450);
    
    cmbMedidaProteccion.on('select',function(cmb,registro)
    								{
                                    	
                                    }
    					)
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',                                            
											items: 	[
                                            			{
                                                        	xtype:'label',
                                                            html:'Imputado:',
                                                            x:10,
                                                            y:10
                                                        },
                                                        cmbImputado,
                                            			{
                                                        	xtype:'label',
                                                            html:'Condici&oacute;n de suspensi&oacute;n:',
                                                            x:10,
                                                            y:40
                                                        },
                                                        cmbMedidaProteccion,
                                                        
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            id:'fieldGeneral',
                                                        	xtype:'fieldset',
                                                            width:600,
                                                            height:180,
                                                            layout:'absolute',
                                                            title:'Detalles adicionales',
                                                            items:	[
                                                            			
                                                                        {
                                                                        	x:10,
                                                                            y:10,
                                                                        	xtype:'label',
                                                                            html:'Especificaciones de la condici&oacute;n de suspensi&oacute;n:'
                                                                        },
                                                                        {
                                                                        	x:10,
                                                                            y:40,
                                                                            width:560,
                                                                            height:80,
                                                                            xtype:'textarea',
                                                                            id:'txtComentarios'
                                                                        }
                                                            		]
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Registro de condici&oacute;n de suspensi&oacute;n:',
										width: 650,
										height:330,
                                        id:'vMedida',
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
                                                                    
                                                                    	var existeRegistro=false;
                                                                        var x;
                                                                        var fila;
                                                                        
                                                                    
                                                                    
                                                                    	if(cmbImputado.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	cmbImputado.fcous();
                                                                            }
                                                                            msgBox('Debe indicar el imputado al cual se aplica la condici&oacute;n de suspensi&oacute;n',resp1);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(cmbMedidaProteccion.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbImputado.fcous();
                                                                            }
                                                                            msgBox('Debe indicar la condici&oacute;n de suspensi&oacute;n',resp2);
                                                                            return;
                                                                        }
                                                                        
                                                                        
                                                                        for(x=0;x<gEx('gridMedidaProteccion').getStore().getCount();x++)
                                                                        {
                                                                        	fila=gEx('gridMedidaProteccion').getStore().getAt(x);
                                                                            if((fila.data.idMedida==cmbMedidaProteccion.getValue())&&(fila.data.idImputado==cmbImputado.getValue()))
                                                                            {

                                                                            	if((!filaRegistro)||(fila.data.idRegistroMedida!=filaRegistro.data.idRegistroMedida))
                                                                            	{
                                                                            		msgBox('La condici&oacute;n de suspensi&oacute;n ya ha sido aplicada al imputado');
                                                                            		return;
                                                                               	}
                                                                            }
                                                                        }
                                                                        
                                                                    	var datosMedida='{"idRegistroMedida":"'+((filaRegistro)?filaRegistro.data.idRegistroMedida:-1)+
                                                                        				'","idMedida":"'+cmbMedidaProteccion.getValue()+'","comentariosAdicionales":"'+cv(gEx('txtComentarios').getValue())+
                                                                                        '"}';
                                                                        
                                                                        
                                                                        var cadObj='{"idActividad":"'+gE('idActividad').value+'","idEvento":"'+gE('idEvento').value+'","idImputado":"'+cmbImputado.getValue()+'","datosMedida":'+datosMedida+'}';
                                                                        
                                                                       	function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                             	gEx('gridCondicionesSuspension').getStore().reload(); 
                                                                                ventanaAM.close();  
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=77&cadObj='+cadObj,true);
                                                                        
                                                                        
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
    
    if(filaRegistro)
    {
    	cmbImputado.setValue(filaRegistro.data.idImputado);
        cmbMedidaProteccion.setValue(filaRegistro.data.idMedida);
      	gEx('txtComentarios').setValue(escaparBR(filaRegistro.data.comentariosAdicionales,true));
    }
    		
}

function crearGridDocumentosAcuerdo()
{	
    var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			 {name: 'idDocumento'},
                                                          {name: 'nombreDocumento'},
                                                          {name: 'tamano'}
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
                                                            sortInfo: {field: 'nombreDocumento', direction: 'ASC'},
                                                            groupField: 'nombreDocumento',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:false
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	//proxy.baseParams.funcion='92';
                                        //proxy.baseParams.idEvento=gE('idEvento').value;
                                        
                                    }
                        )   
       
    
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	
														chkRow,
                                                        {
                                                            header:'',
                                                            width:30,
                                                            sortable:true,
                                                            dataIndex:'idDocumento',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	var arrNombre=registro.data.nombreDocumento.split('.');
                                                                        return '<img src="../imagenesDocumentos/16/file_extension_'+arrNombre[arrNombre.length-1].toLowerCase()+'.png" />'
                                                                    }
                                                        },
														{
															header:'Nombre documento',
															width:250,
															sortable:true,
															dataIndex:'nombreDocumento'
														},
                                                        {
															header:'Tama&ntilde;o',
															width:150,
															sortable:true,
															dataIndex:'tamano',
                                                            renderer:function(val)
                                                            		{
                                                                    	return bytesToSize(parseInt(val),0);
                                                                    }
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:false,
                                                            y:215,
                                                            x:200,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            id:'gDocumentosAcuerdos',
                                                            columnLines : true,
                                                            height:140,
                                                            width:500,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            id:'btnAddAcuerdo',
                                                                            text:'Agregar documento de acuerdo',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaAgregarDocumento();
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            id:'btnDelAcuerdo',
                                                                            text:'Remover documento de acuerdo',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el documento que desea remover');
                                                                                        	return;
                                                                                        }
                                                                                        
                                                                                        
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	tblGrid.getStore().remove(fila);
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el documento seleccionado?',resp);
                                                                                        
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	
    tblGrid.on('rowdblclick',function(grid,rowIndex)
                              {
                              		var registro=grid.getStore().getAt(rowIndex);
                                    
                                    
                                    var arrNombre=registro.data.nombreDocumento.split('.');
                                    mostrarVisorDocumentoProceso(arrNombre[arrNombre.length-1].toLowerCase(),registro.data.idDocumento,registro);
									                                  
                              }
                  )   
    
    return 	tblGrid;
}

function habilitarAcuerdo()
{
	gEx('btnAddAcuerdo').show();
    gEx('btnDelAcuerdo').show();
    gEx('txtResumen').setReadOnly(false);
 	gEx('cmbTipoCumplimiento').enable();   
    gEx('cmbApruebaAcuerdo').enable(); 
    gEx('dteFechaExticion').enable();  
}

function desHabilitarAcuerdo()
{
	
    gEx('txtResumen').setReadOnly(true);
 	gEx('cmbTipoCumplimiento').disable();   
    gEx('cmbApruebaAcuerdo').disable(); 
    gEx('dteFechaExticion').disable();  
    gEx('btnAddAcuerdo').hide();
    gEx('btnDelAcuerdo').hide();
}

function guardarInforme(funcionFinal)
{
	var arrInforme='';
    var fila;
    var x;
    var tblGrid=gEx('gridResolutivos');
    for(x=0;x<tblGrid.getStore().getCount();x++)
    {
        fila=tblGrid.getStore().getAt(x);
        if(fila.data.aplicado)
        {
        
            if((fila.data.valor=='')&&(fila.data.tipoValor!='7'))
            {
                msgBox('Debe ingresar el valor de: '+fila.data.resolutivo);
                return;
            }
            var valor=fila.data.valor;
            if(valor.format)
                valor=valor.format('Y-m-d');
            o='{"idResolutivo":"'+fila.data.idResolutivo+'","valor":"'+cv(valor)+'","comentariosAdicionales":"'+cv(fila.data.comentariosAdicionales)+'"}';
            if(arrInforme=='')
                arrInforme=o;
             else
                arrInforme+=','+o;
        }
    }
    
    
   
    
    
    
    var obj='{"idEvento":"'+gE('idEvento').value+'","registros":['+arrInforme+']}';
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	if(funcionFinal)
            	funcionFinal();
            else
            {
                msgBox('La informaci&oacute;n ha sido almacenada correctamente');
                return;
            }
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=64&cadObj='+obj,true);
    
}

function mostrarVentanaAgregarDocumento()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:0,
                                                            y:0,
                                                            html:	'<span id="tblUpload">'+
                                                            		'<table width="720"><tr><td><div id="uploader"><p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p></div></td></tr></table>'+
                                                                	'</span>'
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar acuerdo',
										width: 750,
										height:350,
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
                                                                	$("#uploader").pluploadQueue({
                                    
                                                                                                    runtimes : 'html5,flash,silverlight,html4',
                                                                                                    url : "../modulosEspeciales_SGJP/procesarDocumentoAcuerdo.php",
                                                                                                    prevent_duplicates:true,
                                                                                                    file_data_name:'archivoEnvio',
                                                                                                    multiple_queues:true,
                                                                                                    max_retries:10,
                                                                                                    
                                                                                                    multipart_params:	{
                                                                                                                            idEvento:gE('idEvento').value,
                                                                                                                            cA:gE('carpetaAdministrativa')
                                                                                                                        },
                                                                                                    
                                                                                                    rename : true,
                                                                                                    dragdrop: true,
                                                                                                    init:	{	
                                                                                                    	
                                                                                                                UploadComplete:function(up,archivos)
                                                                                                                                {
                                                                                                                                 	//gEx('gDocumentosAcuerdos').getStore().reload();
                                                                                                                                    ventanaAM.close();
                                                                                                                                },
                                                                                                               	FileUploaded:function(up,archivos,response)
                                                                                                                				{
                                                                                                                                	var arrRespuesta=response.response.split("|");
                                                                                                                                    
                                                                                                                                    var reg=crearRegistro	(
                                                                                                                                    							[
                                                                                                                                                                	{name: 'idDocumento'},
                                                                                                                                                                  	{name: 'nombreDocumento'},
                                                                                                                                                                  	{name: 'tamano'}
                                                                                                                                                                ]
                                                                                                                                    						);
                                                                                                                                    
                                                                                                                                    var r=new reg	(
                                                                                                                                    					{
                                                                                                                                                        	idDocumento:arrRespuesta[1],
                                                                                                                                                            nombreDocumento:arrRespuesta[2],
                                                                                                                                                            tamano:arrRespuesta[3]
                                                                                                                                                            
                                                                                                                                                        }
                                                                                                                                    				)
                                                                                                                                    gEx('gDocumentosAcuerdos').getStore().add(r);
                                                                                                                                    
                                                                                                                                    up.removeFile(archivos);
                                                                                                                                    
                                                                                                                                }
                                                                                                            },
                                                                                                    filters : 	{
                                                                                                                    // Maximum file size
                                                                                                                    max_file_size : '512mb',
                                                                                                                    // Specify what files to browse for
                                                                                                                    mime_types: [
                                                                                                                        {title : "Archivos de imagen", extensions : "jpg,gif,png"},
                                                                                                                        {title : "Documentos PDF", extensions : "pdf"}
                                                                                                                    ]
                                                                                                                },
                                                                                             
                                                                                                    // Resize images on clientside if we can
                                                                                                    resize: {
                                                                                                                width : 200,
                                                                                                                height : 200,
                                                                                                                quality : 90,
                                                                                                                crop: true // crop to exact dimensions
                                                                                                            },
                                                                                             
                                                                                             
                                                                                                    // Flash settings
                                                                                                    flash_swf_url : '../Scripts/plupload/js/Moxie.swf',
                                                                                                 
                                                                                                    // Silverlight settings
                                                                                                    silverlight_xap_url : '../Scripts/plupload/js/Moxie.xap'
                                                                                                });
																
                                                                	$("#uploader").bind('UploadComplete', function(up, files) 
                                                                                                          {
                                                                                                              // Called when all files are either uploaded or failed
                                                                                                              alert('ok');
                                                                                                         }
                                                                 
                                                                 						)
                                                                                                          
                                                                                                          
                                                                }
															}
												},
										buttons:	[
														{
															
															text: 'Cerrar',
                                                            
															handler: function()
																	{
																		ventanaAM.close();
																	}
														}
														
													]
									}
								);
	ventanaAM.show();
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
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=65&idEvento='+gE('idEvento').value,true);
}

function mostrarVentanaAcuerdoReparatorio(fDatosAcuerdo)
{
	var cmbImputado=crearComboExt('cmbImputado',arrImputados,200,5,420,{multiSelect:true});
	var cmbTipoCumplimiento=crearComboExt('cmbTipoCumplimiento',arrTipoCumplimiento,200,80,150);
    var cmbApruebaAcuerdo=crearComboExt('cmbApruebaAcuerdo',arrSiNo,540,80,150);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                            x:20,
                                                            y:10,
                                                            xtype:'label',
                                                            html:'Imputado:'
                                                        },
                                                        cmbImputado,
                                                        {
                                                            x:20,
                                                            y:40,
                                                            xtype:'label',
                                                            html:'Resumen del acuerdo:'
                                                        },
                                                        {
                                                            xtype:'textarea',
                                                            width:550,
                                                            height:40,
                                                            id:'txtResumen',
                                                            x:200,
                                                            y:35
                                                        },
                                                        {
                                                            x:10,
                                                            y:85,
                                                            xtype:'label',
                                                            html:'Tipo de cumplimiento:'
                                                        },
                                                        cmbTipoCumplimiento,
                                                        {
                                                            x:380,
                                                            y:85,
                                                            xtype:'label',
                                                            html:'¿Se aprueba el acuerdo?:'
                                                        },
                                                        cmbApruebaAcuerdo,
                                                        {
                                                            x:10,
                                                            y:115,
                                                            xtype:'label',
                                                            html:'Fecha de extinci&oacute;n de la acci&oacute;n penal:'
                                                        },
                                                        {
                                                            x:220,
                                              
                                                            y:110,
                                                            xtype:'datefield',
                                                            id:'dteFechaExticion'
                                                        },
                                                        {
                                                            x:10,
                                                            y:145,
                                                            xtype:'label',
                                                            html:'Comentarios adicionales:'
                                                        },
                                                        {
                                                        	x:200,
                                                            y:145,
                                                            xtype:'textarea',
                                                            width:550,
                                                            height:60,
                                                            id:'txtComentarios'
                                                        },
                                                        {
                                                            x:10,
                                                            y:215,
                                                            xtype:'label',
                                                            html:'Documentos de acuerdo:'
                                                        },
                                                        crearGridDocumentosAcuerdo()

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Acuerdo reparatorio',
										width: 800,
										height:440,
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
																		
                                                                        
                                                                        if(cmbImputado.getValue()=='')
                                                                        {
                                                                        	function respImputado()
                                                                            {
                                                                            	cmbImputado.focus();
                                                                            }
                                                                            msgConfirm('Debe indicar el imputado al cual pertenece el acuerdo reparatorio',respImputado);
                                                                        	return;
                                                                        }
                                                                        
                                                                       
                                                                        
                                                                        /*var x;
                                                                        var fila;
                                                                        for(x<0;x<gEx('gridAcuerdosReparatorios').getStore().getCount();x++)
                                                                        {
                                                                        	fila=gEx('gridAcuerdosReparatorios').getStore().getAt(x);
                                                                            
                                                                            if((fila.data.Imputado==cmbImputado.getValue())&&(!fDatosAcuerdo))
                                                                            {
                                                                            	msgBox('Ya existe un registro de acuerdo reparatorio para el imputado indicado');
                                                                            	return;
                                                                            }                                                                            
                                                                            
                                                                        }*/
                                                                        
                                                                        var txtResumen=gEx('txtResumen');
                                                                        var cmbTipoCumplimiento=gEx('cmbTipoCumplimiento');   
                                                                        var cmbApruebaAcuerdo=gEx('cmbApruebaAcuerdo'); 
                                                                        var dteFechaExticion=gEx('dteFechaExticion');  
                                                                        var gDocumentosAcuerdos=gEx('gDocumentosAcuerdos');
                                                                        
                                                                        
                                                                        if(gEx('txtResumen').getValue()=='')
                                                                        {
                                                                            function resp()
                                                                            {
                                                                                gEx('txtResumen').focus();
                                                                            }
                                                                            msgBox('Debe ingresar un breve resumen del acuerdo',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(cmbTipoCumplimiento.getValue()=='')
                                                                        {
                                                                            function resp2()
                                                                            {
                                                                                cmbTipoCumplimiento.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el tipo de cumplimiento del acuerdo',resp2);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(cmbApruebaAcuerdo.getValue()=='')
                                                                        {
                                                                            function resp3()
                                                                            {
                                                                                cmbApruebaAcuerdo.focus();
                                                                            }
                                                                            msgBox('Debe indicar si se aprueba el acuerdo',resp3);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(gEx('txtResumen').getValue()=='')
                                                                        {
                                                                            function resp4()
                                                                            {
                                                                                gEx('txtResumen').focus();
                                                                            }
                                                                            msgBox('Debe indicar el resumen del acuerdo',resp4);
                                                                            return;
                                                                        }
                                                                        
                                                                        var listaAcuerdos='';
                                                                        var oDocumento='';
                                                                        for(x=0;x<gDocumentosAcuerdos.getStore().getCount();x++)
                                                                        {
                                                                            fila=gDocumentosAcuerdos.getStore().getAt(x);
                                                                            
                                                                            oDocumento='{"idDocumento":"'+fila.data.idDocumento+'","nombreDocumento":"'+cv(fila.data.nombreDocumento)+'"}';
                                                                            if(listaAcuerdos=='')
                                                                                listaAcuerdos=oDocumento;
                                                                            else
                                                                                listaAcuerdos+=','+oDocumento;
                                                                        }
                                                                        
                                                                        
                                                                        /*if(listaAcuerdos=='')
                                                                        {
                                                                            function resp5()
                                                                            {
                                                                                gEx('tpResolutivos').setActiveTab(1);
                                                                                
                                                                            }
                                                                            msgBox('Debe ingresar el documento de acuerdo',resp5);
                                                                            return;
                                                                        }*/
                                                                        
                                                                        datosAcuerdo='{"idRegistro":"'+(fDatosAcuerdo?fDatosAcuerdo.data.idRegistro:-1)+'","idEvento":"'+gE('idEvento').value+'","imputado":"'+cmbImputado.getValue()+'","resumen":"'+cv(gEx('txtResumen').getValue())+'","tipoCumplimiento":"'+cv(cmbTipoCumplimiento.getValue())+
                                                                                '","apruebaAcuerdo":"'+cv(cmbApruebaAcuerdo.getValue())+'","fechaExtincion":"'+(dteFechaExticion.getValue()==''?'':dteFechaExticion.getValue().format('Y-m-d'))+
                                                                                '","documentosAcuerdo":['+listaAcuerdos+'],"comentariosAdicionales":"'+cv(gEx('txtComentarios').getValue())+'"}';
                                                                                
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('gridAcuerdosReparatorios').getStore().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=100&cadObj='+datosAcuerdo,true);

                                                                        
                                                                        
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
	
    if(fDatosAcuerdo)
    {
    	cmbImputado.setValue(fDatosAcuerdo.data.idImputado);
        gEx('txtResumen').setValue(escaparBR(fDatosAcuerdo.data.resumenAcuerdo,true));
        cmbTipoCumplimiento.setValue(fDatosAcuerdo.data.tipoCumplimiento);
        cmbApruebaAcuerdo.setValue(fDatosAcuerdo.data.acuerdoAprobado);
        gEx('dteFechaExticion').setValue(fDatosAcuerdo.data.fechaExtincionAccionPenal);
        gEx('txtComentarios').setValue(escaparBR(fDatosAcuerdo.data.comentariosAdicionales,true));
        
        var x;
        var reg=crearRegistro	(
        							[
                                    	{name: 'idDocumento'},
                                        {name: 'nombreDocumento'},
                                        {name: 'tamano'}
                                    ]
        						);
		
        var r;
        
        
                          
        
        for(x=0;x<fDatosAcuerdo.data.arrDocumentos.length;x++)
        {
        	 r=new      reg	(
        						{
                                	idDocumento:fDatosAcuerdo.data.arrDocumentos[x].idDocumento,
                                    nombreDocumento:fDatosAcuerdo.data.arrDocumentos[x].nombreDocumento,
                                    tamano:fDatosAcuerdo.data.arrDocumentos[x].tamano
                                }
        					)   
	        gEx('gDocumentosAcuerdos').getStore().add(r);
    	}    
    }                                
                                
	ventanaAM.show();
															
}

function crearGridAcuerdosReparatorios()
{
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idImputado'},
		                                                {name: 'resumenAcuerdo'},
		                                                {name:'tipoCumplimiento'},
		                                                {name:'acuerdoAprobado'},
                                                        {name: 'fechaExtincionAccionPenal', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'arrDocumentos'},
                                                        {name: 'comentariosAdicionales'},
                                                        {name: 'idRegistro'}
                                                        
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
                                                            sortInfo: {field: 'idImputado', direction: 'ASC'},
                                                            groupField: 'idImputado',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='102';
                                        proxy.baseParams.idEvento=gE('idEvento').value;
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            
                                                            chkRow,
                                                            {
                                                                header:'Imputado',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'idImputado',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrImputados,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Tipo de cumplimiento',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'tipoCumplimiento',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrTipoCumplimiento,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Acuerdo aprobado',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'acuerdoAprobado',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrSiNo,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Fecha de extinci&oacute;n de<br>la acci&oacute;n penal',
                                                                width:180,
                                                                sortable:true,
                                                                dataIndex:'fechaExtincionAccionPenal',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(val)
                                                                            	return val.format('d/m/Y');
                                                                        }
                                                            },
                                                            
                                                              {
                                                                  header:'Comentarios adicionales',
                                                                  width:600,
                                                                  sortable:true,
                                                                  dataIndex:'comentariosAdicionales',
                                                                  renderer:function(val)
                                                                          {
                                                                              return val;
                                                                          }
                                                              }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridAcuerdosReparatorios',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                tbar:	[
                                                                            {
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Agregar registro de acuerdo reparatorio',
                                                                                handler:function()
                                                                                        {
                                                                                            mostrarVentanaAcuerdoReparatorio();
                                                                                        }
                                                                                
                                                                            }
                                                                            ,'-',
                                                                            {
                                                                                icon:'../images/pencil.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Modificar registro de acuerdo reparatorio',
                                                                                handler:function()
                                                                                        {
                                                                                        
                                                                                        	var fila=tblGrid.getSelectionModel().getSelected()
                                                                                        	if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar el registro de acuerdo que desea modificar');
                                                                                            	return;
                                                                                            }
                                                                                            mostrarVentanaAcuerdoReparatorio(fila)
                                                                                        }
                                                                                
                                                                            }
                                                                            ,'-',
                                                                            {
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Remover registro de acuerdo reparatorio',
                                                                                handler:function()
                                                                                        {
                                                                                            var fila=tblGrid.getSelectionModel().getSelected()
                                                                                        	if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar el registro de acuerdo que desea remover');
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
                                                                                                            gEx('gridAcuerdosReparatorios').getStore().reload();
                                                                                                           
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=101&idAcuerdo='+
                                                                                                    fila.data.idRegistro,true);
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer remover el registro de acuerdo seleccionado?',resp);
                                                                                            
                                                                                        }
                                                                                
                                                                            }
                                                                            
                                                                        ],
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                sm:chkRow,
                                                                columnLines : true,
                                                                title:'Acuerdos reparatorios',                                                                
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :false,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: false,
                                                                                                    startCollapsed:false,
                                                                                                    getRowClass : formatearFila
                                                                                                })
                                                            }
                                                        );
        return 	tblGrid;	
}

function formatearFila(record, rowIndex, p, ds) 
{
	var xf = Ext.util.Format;
    p.body = '<br><br><table width="100%"><tr><td width="30"></td><td><b>Resumen del acuerdo</b><br><br>'+record.data.resumenAcuerdo+'</td></tr></table><br><br>';
    return 'x-grid3-row-expanded';
}

