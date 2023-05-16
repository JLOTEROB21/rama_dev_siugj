<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$idEvento=$_GET["iE"];
	
	$consulta="SELECT valor,texto FROM 1004_siNo";
	$arrSiNo=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT carpetaAdministrativa  FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 AND idRegistroContenidoReferencia=".$idEvento;
	$cAdministrativa=$con->obtenerValor($consulta);
	
	$consulta="SELECT tipoCarpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cAdministrativa."'";
	$tipoCarpeta=$con->obtenerValor($consulta);
	
	
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
				WHERE unidadGestion='".$unidadGestion."' and carpetaAdministrativa<>'".$cAdministrativa."'";
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
var tipoCarpeta=<?php echo $tipoCarpeta?>;
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
var arrSituacionAcuerdo=[['1','Activo','0F6B01'],['2','Revocado','F00'],['3','Cumplido','051569']];

var arrAcuerdo=<?php echo $arrAcuerdo?>;
var idResolutivo=-1;
var tipoResultado='';
var registroSeleccionado=null;
var idFormato=-1;

var sLectura=false;

Ext.onReady(inicializar);

function inicializar()
{
	loadScript('../modulosEspeciales_SGJP/Scripts/cComputo.js.php',function(){});
	
	loadScript('../modulosEspeciales_SGJ/Scripts/controlEventos.js.php', function()
    																		{
                                                                            	var objConf={};
                                                                                objConf.idEvento=gE('idEvento').value;
                                                                                objConf.renderTo='tblAudiencia';
                                                                                objConf.permiteModificarTipoAudiencia=(gE('situacionInforme').value=='1')?false:true;
                                                                                objConf.permiteModificarHorarioDesarrollo=false;
                                                                                objConf.mostrarDesarrollo=false;
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
                                                                                objConf.mostrarHorarioDesarrollo=false;
                                                                                objConf.mostrarDocumentoMultimedia=false;
                                                                            	construirTableroEvento(objConf);
                                                                            }
			)   
            
    
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                border:false,
                                                frame:false,
                                               
                                                items:	[
                                                            {
                                                                id:'tpResolutivos',
                                                                xtype:'tabpanel',
                                                                region:'center',
                                                                border:true,
                                                                plain:true,                                                                
                                                                activeTab:0,
                                                                items:	[
                                                                			{
                                                                            	xtype:'panel',
                                                                                layout:'absolute',
                                                                                border:false,
                                                                                frame:false,
                                                                                title:'Datos de la audiencia',
                                                                                items:	[
                                                                                			{
                                                                                            	x:0,
                                                                                                y:0,
                                                                                                xtype:'label',
                                                                                                html:'<span id="tblAudiencia"></span>'
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
            
	new Ext.TabPanel	(
    						
    					)            
                                                                                     

	
    
    if(sLectura)
    {
    	desHabilitarAcuerdo();
    }
    
}

function crearGridAccionesResolutivos()
{
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idResolutivo'},
                                                        {name:'aplicado'},
		                                                {name: 'resolutivo'},
                                                        {name: 'tipoValor'},
		                                                {name:'valor'},
                                                        {name:'prioridad'},
                                                        {name: 'comentariosAdicionales'},
                                                        {name:'opciones'},
                                                        {name: 'opcionesSeleccionadas'},
                                                        {name: 'tblOpciones'}
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

		var expander = new Ext.ux.grid.RowExpander({
                                                    column:2,
                                                    tpl : new Ext.Template(
                                                        '<table width="100%" >'+
                                                        '<tr>'+
                                                        	'<td  style="padding:10px">'+
                                                            '{tblOpciones}'+
                                                            '</td>'+
                                                        '</tr>'+
                                                        '</table>'
                                                    )
                                                }); 	
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            expander,
	                                                          chkRow,
                                                            {
                                                                header:'Accion/Resolutivo',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'resolutivo'
                                                            },
                                                            {
                                                                header:'Valor',
                                                                width:260,
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
                                                                                        comp=' (A&ntilde;os: '+oVal.anios+'|Meses: '+oVal.meses+'|Dias: '+oVal.dias+'): '+Date.parseDate(oVal.fechaFinal,'Y-m-d').format('d/m/Y');
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
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
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
                                                                sm:chkRow,    
                                                                plugins:[expander],                                                         
                                                                columnLines : false,     
                                                                tbar:	[
                                                                			
                                                                            {
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:(gE('situacionInforme').value=='1'),
                                                                                text:'Agregar resolutivo',
                                                                                handler:function()
                                                                                        {
                                                                                        	mostrarVentanaAgregarResolutivo();
                                                                                            
                                                                                            
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/pencil.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:(gE('situacionInforme').value=='1'),
                                                                                text:'Modificar resolutivo',
                                                                                handler:function()
                                                                                        {
                                                                                        	var fila=gEx('gridResolutivos').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar el resolutivo que desea modificar');
                                                                                            	return;
                                                                                            }
                                                                                        	mostrarVentanaAgregarResolutivo(fila);
                                                                                            
                                                                                            
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:(gE('situacionInforme').value=='1'),
                                                                                text:'Remover resolutivo',
                                                                                handler:function()
                                                                                        {
                                                                                        	
                                                                                            var fila=gEx('gridResolutivos').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar el resolutivo que desea remover');
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
                                                                                                             gEx('gridResolutivos').getStore().reload();
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=234&idEvento='+gE('idEvento').value+'&iR='+fila.data.idResolutivo,true);
                                                                                                    
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer remover el resolutivo seleccionado?',resp);
                                                                                            
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
                                                        {name: 'valorComp3'},
                                                        {name: 'historialSituacionMedida'},
                                                        {name: 'situacionActual'},
                                                        {name: 'idEventoAudiencia'}
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
                                    	gEx('btnMedidaCautelarDel').hide();
                                        gEx('btnMedidaCautelarMod').hide();
                                        gEx('btnModificarSituacionMedidaCautelar').show();
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
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'idMedida',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrMedidasCautelares,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Imputado',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'idImputado',
                                                                renderer:function(val)
                                                                		{
                                                                        	return "Imputado: "+formatearValorRenderer(arrImputados,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Detalle',
                                                                width:300,
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
                                                                width:400,
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
                                                            },

                                                            {
                                                                header:'Situaci&oacute;n actual',
                                                                width:140,
                                                                sortable:true,
                                                                dataIndex:'situacionActual',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var comp='';
                                                                            if(registro.data.historialSituacionMedida!='0')
                                                                            {
                                                                            	comp='<a href="javascript:verHistorialSituacionMedida(\''+bE(registro.data.idRegistroMedida)+'\')"><img width=\'14\' height=\'14\' src=\'../images/report.png\' title=\'Ver historial\' alt=\'Ver historial\'></a>&nbsp;&nbsp;';
                                                                            }
                                                                            var pos=existeValorMatriz(arrSituacionAcuerdo,val);
                                                                            var leyenda=arrSituacionAcuerdo[pos][1];
                                                                            
                                                                            leyenda='<span style="color:#'+arrSituacionAcuerdo[pos][2]+'; font-weight:bold">'+leyenda+'</span>';
                                                                            
                                                                        	return comp+leyenda;
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
                                                                            	id:'btnMedidaCautelarMod',
                                                                                icon:'../images/pencil.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:true,
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
                                                                                
                                                                            },
                                                                            '-',
                                                                            {
                                                                            	id:'btnMedidaCautelarDel',
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:true,
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
                                                                            	id:'btnModificarSituacionMedidaCautelar',
                                                                                icon:'../images/vcard_edit.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:true,
                                                                                text:'Modificar situaci&oacute;n de la medida cautelar',
                                                                                handler:function()
                                                                                        {
																							var fila=tblGrid.getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar la medida cautelar cuya situaci&oacute;n desea modificar');
                                                                                                return;
                                                                                            }
                                                                                            
                                                                                            
                                                                                            
                                                                                            window.parent.ocultarPanelDerecho();
                                                                                            setTimeout	(
                                                                                            				function()
                                                                                                            {
                                                                                                            	mostrarVentanaCambiarSituacionMedidaCautelar(fila)
                                                                                                            },
                                                                                                            200
                                                                                            			)
                                                                                            
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
                                                        
	
    tblGrid.getSelectionModel().on('rowselect',function(sm,nFila,registro)
        										{
                                                	gEx('btnMedidaCautelarDel').hide();
			                                        gEx('btnMedidaCautelarMod').hide();
                                                    gEx('btnModificarSituacionMedidaCautelar').hide();
                                                    
                                                    if(gE('situacionInforme').value=='1')
                                                    {
                                                    	return;
                                                    }
                                                	if((registro.data.historialSituacionMedida=='0')&&(registro.data.idEventoAudiencia==gE('idEvento').value))
                                                    {
                                                        gEx('btnMedidaCautelarDel').show();
                                                        gEx('btnMedidaCautelarMod').show();
                                                    }
                                                    else
                                                    {
                                                    	gEx('btnModificarSituacionMedidaCautelar').show();
                                                    	
                                                        
                                                    	
                                                    }
                                                   
                                                }
        								)
        
        tblGrid.getSelectionModel().on('rowdeselect',function(sm,nFila,registro)
        										{
                                                	gEx('btnMedidaCautelarDel').hide();
			                                        gEx('btnMedidaCautelarMod').hide();
                                                    gEx('btnModificarSituacionMedidaCautelar').hide();
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
                                                        	x:426,
                                                            y:7,
                                                            html:'<a href="javascript:agregarImputado()"><img src="../images/add.png" title="Agregar Imputado" alt="Agregar Imputado"/></a>'
                                                        },
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
                                                        {name: 'comentariosAdicionales'},
                                                        {name: 'historialSituacionMedidaProteccion'},
                                                        {name: 'situacionActual'},
                                                        {name: 'idEventoAudiencia'}
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
                                    	gEx('btnMedidaProteccionMod').hide();
                                        gEx('btnMedidaProteccionDel').hide();
                                        gEx('btnMedidaProteccionSituacion').hide();
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
                                                            },

                                                            {
                                                                header:'Situaci&oacute;n actual',
                                                                width:140,
                                                                sortable:true,
                                                                dataIndex:'situacionActual',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var comp='';
                                                                            if(registro.data.historialSituacionMedidaProteccion!='0')
                                                                            {
                                                                            	comp='<a href="javascript:verHistorialSituacionMedidaProteccion(\''+bE(registro.data.idRegistroMedida)+'\')"><img width=\'14\' height=\'14\' src=\'../images/report.png\' title=\'Ver historial\' alt=\'Ver historial\'></a>&nbsp;&nbsp;';
                                                                            }
                                                                            var pos=existeValorMatriz(arrSituacionAcuerdo,val);
                                                                            var leyenda=arrSituacionAcuerdo[pos][1];
                                                                            
                                                                            leyenda='<span style="color:#'+arrSituacionAcuerdo[pos][2]+'; font-weight:bold">'+leyenda+'</span>';
                                                                            
                                                                        	return comp+leyenda;
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
                                                                            	id:'btnMedidaProteccionMod',
                                                                                icon:'../images/pencil.png',
                                                                                cls:'x-btn-text-icon',
                                                                               
                                                                                hidden:true,
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
                                                                            
                                                                            
                                                                            ,'-',
                                                                            {
                                                                            	id:'btnMedidaProteccionDel',
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:true,
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
                                                                            	id:'btnMedidaProteccionSituacion',
                                                                                icon:'../images/vcard_edit.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:true,
                                                                                text:'Modificar situaci&oacute;n de la medida de protecci&oacute;n',
                                                                                handler:function()
                                                                                        {
																							var fila=tblGrid.getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar la medida de proyecci&oacute;n cuya situaci&oacute;n desea modificar');
                                                                                                return;
                                                                                            }
                                                                                            
                                                                                            
                                                                                            
                                                                                            window.parent.ocultarPanelDerecho();
                                                                                            setTimeout	(
                                                                                            				function()
                                                                                                            {
                                                                                                            	mostrarVentanaCambiarSituacionMedidaProteccion(fila)
                                                                                                            },
                                                                                                            200
                                                                                            			)
                                                                                            
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
                                                        
	 tblGrid.getSelectionModel().on('rowselect',function(sm,nFila,registro)
        										{
                                                	gEx('btnMedidaProteccionMod').hide();
			                                        gEx('btnMedidaProteccionDel').hide();
                                                    gEx('btnMedidaProteccionSituacion').hide();
                                                    
                                                    if(gE('situacionInforme').value=='1')
                                                    {
                                                    	return;
                                                    }
                                                	if((registro.data.historialSituacionMedidaProteccion=='0')&&(registro.data.idEventoAudiencia==gE('idEvento').value))
                                                    {
                                                        gEx('btnMedidaProteccionMod').show();
			                                        	gEx('btnMedidaProteccionDel').show();
                                                    }
                                                    else
                                                    {
                                                    	gEx('btnMedidaProteccionSituacion').show();
                                                    	
                                                        
                                                    	
                                                    }
                                                   
                                                }
        								)
        
        tblGrid.getSelectionModel().on('rowdeselect',function(sm,nFila,registro)
        										{
                                                	gEx('btnMedidaProteccionMod').hide();
			                                        gEx('btnMedidaProteccionDel').hide();
                                                    gEx('btnMedidaProteccionSituacion').hide();
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
                                                        	x:473,
                                                            y:7,
                                                            html:'<a href="javascript:agregarImputado()"><img src="../images/add.png" title="Agregar Imputado" alt="Agregar Imputado"/></a>'
                                                        },
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
                                                        {name: 'comentariosAdicionales'},
                                                        {name: 'historialSituacionSuspencion'},
                                                        {name: 'situacionActual'},
                                                        {name: 'idEventoAudiencia'}
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
                                    	gEx('btnSuspensionMod').hide();
                                        gEx('btnSuspensionDel').hide();
                                        gEx('btnSituacionSuspencionCondicional').hide();
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
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n actual',
                                                                width:140,
                                                                sortable:true,
                                                                dataIndex:'situacionActual',
                                                                renderer:function(val,meta,registro)
                                                                        {
                                                                            var comp='';
                                                                            if(registro.data.historialSituacionSuspencion!='0')
                                                                            {
                                                                                comp='<a href="javascript:verHistorialSituacionSuspencionCondicional(\''+bE(registro.data.idRegistroMedida)+'\')"><img width=\'14\' height=\'14\' src=\'../images/report.png\' title=\'Ver historial\' alt=\'Ver historial\'></a>&nbsp;&nbsp;';
                                                                            }
                                                                            var pos=existeValorMatriz(arrSituacionAcuerdo,val);
                                                                            var leyenda=arrSituacionAcuerdo[pos][1];
                                                                            
                                                                            leyenda='<span style="color:#'+arrSituacionAcuerdo[pos][2]+'; font-weight:bold">'+leyenda+'</span>';
                                                                            
                                                                            return comp+leyenda;
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
                                                                                
                                                                            }
                                                                            ,'-',
                                                                            {
                                                                            	id:'btnSuspensionMod',
                                                                                icon:'../images/pencil.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:true,
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
                                                                            ,'-',
                                                                            {
                                                                            	id:'btnSuspensionDel',
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:true,
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
                                                                            	id:'btnSituacionSuspencionCondicional',
                                                                                icon:'../images/vcard_edit.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:true,
                                                                                text:'Modificar situaci&oacute;n de la Suspensi&oacute;n Condicional',
                                                                                handler:function()
                                                                                        {
																							var fila=tblGrid.getSelectionModel().getSelected(); 
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar la Suspensi&oacute;n Condicional cuya situaci&oacute;n desea modificar');
                                                                                                return;
                                                                                            }
                                                                                            
                                                                                            window.parent.ocultarPanelDerecho();
                                                                                            setTimeout	(
                                                                                            				function()
                                                                                                            {
                                                                                                            	mostrarVentanaCambiarSituacionSuspensionCondicional(fila)
                                                                                                            },
                                                                                                            200
                                                                                            			)
                                                                                            
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
                                                        
		
         tblGrid.getSelectionModel().on('rowselect',function(sm,nFila,registro)
        										{
                                                	gEx('btnSuspensionMod').hide();
			                                        gEx('btnSuspensionDel').hide();
                                                    gEx('btnSituacionSuspencionCondicional').hide();
                                                    
                                                    if(gE('situacionInforme').value=='1')
                                                    {
                                                    	return;
                                                    }
                                                	if((registro.data.historialSituacionSuspencion=='0')&&(registro.data.idEventoAudiencia==gE('idEvento').value))
                                                    {
                                                        gEx('btnSuspensionMod').show();
			                                        	gEx('btnSuspensionDel').show();
                                                    }
                                                    else
                                                    {
                                                    	gEx('btnSituacionSuspencionCondicional').show();
                                                    	
                                                        
                                                    	
                                                    }
                                                   
                                                }
        								)
        
        tblGrid.getSelectionModel().on('rowdeselect',function(sm,nFila,registro)
        										{
                                                	gEx('btnSuspensionMod').hide();
			                                        gEx('btnSuspensionDel').hide();
                                                    gEx('btnSituacionSuspencionCondicional').hide();
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
                                                        	x:473,
                                                            y:7,
                                                            html:'<a href="javascript:agregarImputado()"><img src="../images/add.png" title="Agregar Imputado" alt="Agregar Imputado"/></a>'
                                                        },
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

function crearGridDocumentosAcuerdo(agregar)
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
                                                            y:!agregar?110:210,
                                                            x:!agregar?245:200,
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
    
    
   var gPenasEjecucion=gEx('gPenasEjecucion');
   var arrPenas='';
   var o;
   if(gPenasEjecucion)
   {
   		for(x=0;x<gPenasEjecucion.getStore().getCount();x++)
   		{
   		
   		
   			fila=gPenasEjecucion.getStore().getAt(x);
   			
   			if(funcionFinal)
   			{
   				
   				if(fila.data.arrSustitutivo.length>0)
   				{
   					if((fila.data.seAcoge!='1')&&(fila.data.seAcoge!='0'))
   					{
   						function resp()
   						{
   							
   							gPenasEjecucion.startEditing(x,4);
   						}
   						gEx('tpResolutivos').setActiveTab('gPenasEjecucion');
   						msgBox('Debe indicar si el sentenciado se acoge a alg&uacute;n sustitutivo',resp);
   						return;
   					}
   				}
   				
   				if((fila.data.seAcoge=='1')&&(fila.data.sustitutivoAcoge==''))
   				{
   					
					function resp2()
					{
						
						gPenasEjecucion.startEditing(x,5);
					}
					gEx('tpResolutivos').setActiveTab('gPenasEjecucion');
					msgBox('Debe indicar el sustitutivo al cual se acoge el sentenciado',resp2);
					return;
   					
   				}
   				
   				var arrSentencia=[];
   				
   				if(fila.data.sustitutivoAcoge!='')
				{
					
					var pos=existeValorMatriz(fila.data.arrSustitutivo,fila.data.sustitutivoAcoge);
					
					var f=fila.data.arrSustitutivo[pos];
					arrSentencia=f[2];
					
				}
				else
				{
					arrSentencia=fila.data.periodoPena;
					
				}
   				if((arrSentencia.length>0)&&((fila.data.fechaInicio=='')||!fila.data.fechaInicio))
   				{
   					function resp3()
					{
						
						gPenasEjecucion.startEditing(x,6);
					}
					gEx('tpResolutivos').setActiveTab('gPenasEjecucion');
					msgBox('Debe indicar la fecha en la cual inicia el cumplimiento de la pena',resp3);
					return;
   					
   				}
   			}
   			
   			o='{"idPena":"'+fila.data.idPena+'","seAcoge":"'+fila.data.seAcoge+'","sustitutivoAcoge":"'+fila.data.sustitutivoAcoge+
   				'","seAcogeSuspensionCondicional":"'+fila.data.seAcogeSuspensionCondicional+'","comentariosAdicionales":"'+
   				cv(fila.data.comentariosAdicionales)+'","fechaInicio":"'+(((fila.data.fechaInicio=='')||(fila.data.fechaInicio==null))?'':fila.data.fechaInicio.format('Y-m-d'))+
   				'","fechaCompurga":"'+(((fila.data.fechaCompurga=='')||(fila.data.fechaCompurga==null))?'':fila.data.fechaCompurga.format('Y-m-d'))+'"}';
   			if(arrPenas=="")
   				arrPenas=o;
   			else
   				arrPenas+=','+o;
   			
   			
   		}
   		
   		
   }
    
    
    
    var obj='{"idEvento":"'+gE('idEvento').value+'","registros":['+arrInforme+'],"arrPenas":['+arrPenas+']}';
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
            window.parent.recargarPagina();
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
	
	var cmbImputado=crearComboExt('cmbImputado',arrImputados,200,5,350,{multiSelect:true});
	var cmbTipoCumplimiento=crearComboExt('cmbTipoCumplimiento',arrTipoCumplimiento,200,80,150);
    var cmbApruebaAcuerdo=crearComboExt('cmbApruebaAcuerdo',arrSiNo,540,80,150);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                            x:10,
                                                            y:10,
                                                            xtype:'label',
                                                            html:'Imputado:'
                                                        },
                                                        {
                                                        	xtype:'label',
                                                        	x:563,
                                                            y:7,
                                                            html:'<a href="javascript:agregarImputadoAcuerdo()"><img src="../images/add.png" title="Agregar Imputado" alt="Agregar Imputado"/></a>'
                                                        },
                                                        cmbImputado,
                                                        {
                                                            x:10,
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
                                                            x:245,
                                              
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
                                                        crearGridDocumentosAcuerdo(true)

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
															},
                                                    	close: function()
                                                        		{
                                                                	window.parent.mostrarPanelDerecho();
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
                                                        {name: 'idRegistro'},
                                                        {name: 'situacionActual'},
                                                        {name: 'modificable'},
                                                        {name: 'historialModificacionAcuerdo'},
                                                        {name: 'historialSituacionAcuerdo'},
                                                        {name: 'tblDocumentos'}
                                                        
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
                                    	gEx('btnModificarAcuerdo').hide();
                                        gEx('btnRemoverAcuerdo').hide();
                                        gEx('btnModificarAcuerdoV2').hide();
                                        gEx('btnModificarSituacionAcuerdoV2').hide();
                                    	proxy.baseParams.funcion='102';
                                        proxy.baseParams.idEvento=gE('idEvento').value;
                                        proxy.baseParams.sL=gE('situacionInforme').value=='1'?1:0;
                                    }
                        )   

	var expander = new Ext.ux.grid.RowExpander({
                                                    column:2,
                                                    tpl : new Ext.Template(
                                                        '<table width="100%" >'+
                                                        '<tr>'+
                                                        	'<td  style="padding:10px">'+
                                                            '<b>Resumen del acuerdo:</b><br><br>{resumenAcuerdo}<br><br><b>Comentarios adicionales:</b><br><br>{comentariosAdicionales}<br><br><b>Documentos asociados:</b><br><br>{tblDocumentos}<br><br>'+
                                                            '</td>'+
                                                        '</tr>'+
                                                        '</table>'
                                                    )
                                                }); 	 


       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            
                                                            chkRow,
                                                            expander,
                                                            {
                                                                header:'Imputado',
                                                                width:320,
                                                                sortable:true,
                                                                dataIndex:'idImputado',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrImputados,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Tipo de cumplimiento',
                                                                width:130,
                                                                sortable:true,
                                                                dataIndex:'tipoCumplimiento',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrTipoCumplimiento,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Acuerdo aprobado',
                                                                width:110,
                                                                sortable:true,
                                                                dataIndex:'acuerdoAprobado',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrSiNo,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Fecha de extinci&oacute;n de<br>la acci&oacute;n penal',
                                                                width:140,
                                                                sortable:true,
                                                                dataIndex:'fechaExtincionAccionPenal',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var comp='';
                                                                            if(registro.data.historialModificacionAcuerdo!='0')
                                                                            {
                                                                            	comp='<a href="javascript:verHistorialCambiosAcuerdo(\''+bE(registro.data.idRegistro)+'\')"><img width=\'14\' height=\'14\' src=\'../images/report.png\' title=\'Ver historial\' alt=\'Ver historial\'></a>&nbsp;&nbsp;';
                                                                            }
                                                                        	if(val)
                                                                            	return comp+val.format('d/m/Y');
                                                                        }
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n actual',
                                                                width:140,
                                                                sortable:true,
                                                                dataIndex:'situacionActual',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var comp='';
                                                                            if(registro.data.historialSituacionAcuerdo!='0')
                                                                            {
                                                                            	comp='<a href="javascript:verHistorialSituacionAcuerdo(\''+bE(registro.data.idRegistro)+'\')"><img width=\'14\' height=\'14\' src=\'../images/report.png\' title=\'Ver historial\' alt=\'Ver historial\'></a>&nbsp;&nbsp;';
                                                                            }
                                                                            var pos=existeValorMatriz(arrSituacionAcuerdo,val);
                                                                            var leyenda=arrSituacionAcuerdo[pos][1];
                                                                            
                                                                            leyenda='<span style="color:#'+arrSituacionAcuerdo[pos][2]+'; font-weight:bold">'+leyenda+'</span>';
                                                                            
                                                                        	return comp+leyenda;
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
                                                                                hidden:(gE('situacionInforme').value=='1'),
                                                                                text:'Agregar registro de acuerdo reparatorio',
                                                                                handler:function()
                                                                                        {
                                                                                        	window.parent.ocultarPanelDerecho();
                                                                                            setTimeout	(
                                                                                            				function()
                                                                                                            {
                                                                                                            	mostrarVentanaAcuerdoReparatorio();
                                                                                                            },
                                                                                                            200
                                                                                            			)
                                                                                            
                                                                                        }
                                                                                
                                                                            }
                                                                            ,'-',
                                                                            {
                                                                                icon:'../images/pencil.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:true,
                                                                                id:'btnModificarAcuerdo',
                                                                                text:'Modificar registro de acuerdo reparatorio',
                                                                                handler:function()
                                                                                        {
                                                                                        
                                                                                        	var fila=tblGrid.getSelectionModel().getSelected()
                                                                                        	if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar el registro de acuerdo que desea modificar');
                                                                                            	return;
                                                                                            }
                                                                                            window.parent.ocultarPanelDerecho();
                                                                                            setTimeout	(
                                                                                            				function()
                                                                                                            {
                                                                                                            	mostrarVentanaAcuerdoReparatorio(fila)
                                                                                                            },
                                                                                                            200
                                                                                            			)
                                                                                            
                                                                                        }
                                                                                
                                                                            },
                                                                            {
                                                                                icon:'../images/pencil.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:true,
                                                                                id:'btnModificarAcuerdoV2',
                                                                                text:'Modificar registro de acuerdo reparatorio',
                                                                                handler:function()
                                                                                        {
                                                                                        
                                                                                        	var fila=tblGrid.getSelectionModel().getSelected()
                                                                                        	if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar el registro de acuerdo que desea modificar');
                                                                                            	return;
                                                                                            }
                                                                                            window.parent.ocultarPanelDerecho();
                                                                                            setTimeout	(
                                                                                            				function()
                                                                                                            {
                                                                                                            	mostrarVentanaAcuerdoReparatorioV2(fila)
                                                                                                            },
                                                                                                            200
                                                                                            			)
                                                                                            
                                                                                        }
                                                                                
                                                                            }
                                                                            ,'-',
                                                                            {
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                               	hidden:true,
                                                                                id:'btnRemoverAcuerdo',
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
                                                                                
                                                                            },
                                                                            {
                                                                                icon:'../images/vcard_edit.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:true,
                                                                                id:'btnModificarSituacionAcuerdoV2',
                                                                                text:'Cambiar situaci&oacute;n del acuerdo reparatorio',
                                                                                handler:function()
                                                                                        {
                                                                                        
                                                                                        	var fila=tblGrid.getSelectionModel().getSelected()
                                                                                        	if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar el registro de acuerdo que desea modificar');
                                                                                            	return;
                                                                                            }
                                                                                            window.parent.ocultarPanelDerecho();
                                                                                            setTimeout	(
                                                                                            				function()
                                                                                                            {
                                                                                                            	mostrarVentanaCambiarSituacionAcuerdo(fila)
                                                                                                            },
                                                                                                            200
                                                                                            			)
                                                                                            
                                                                                        }
                                                                                
                                                                            }
                                                                            
                                                                        ],
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                sm:chkRow,
                                                                plugins:[expander],
                                                                columnLines : true,
                                                                title:'Acuerdos reparatorios',                                                                
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
        
        tblGrid.getSelectionModel().on('rowselect',function(sm,nFila,registro)
        										{
                                                	gEx('btnModificarAcuerdo').hide();
                                                   	gEx('btnRemoverAcuerdo').hide();
                                                    gEx('btnModificarAcuerdoV2').hide();
                                                    gEx('btnModificarSituacionAcuerdoV2').hide();
                                                    gEx('btnModificarAcuerdoV2').hide();
                                                            
                                                    if(gE('situacionInforme').value=='1')
                                                    {
                                                    	return;
                                                    }
                                                	if(registro.data.modificable=='1')
                                                    {
                                                        gEx('btnModificarAcuerdo').show();
                                                        gEx('btnRemoverAcuerdo').show();
                                                    }
                                                    else
                                                    {
                                                    	if(registro.data.tipoCumplimiento=='2')
                                                        {
                                                         	gEx('btnModificarAcuerdoV2').show();
                                                            gEx('btnModificarSituacionAcuerdoV2').show();
                                                        }
                                                        
                                                    	
                                                    }
                                                   
                                                }
        								)
        
        tblGrid.getSelectionModel().on('rowdeselect',function(sm,nFila,registro)
        										{
                                                	gEx('btnModificarAcuerdo').hide();
                                                   	gEx('btnRemoverAcuerdo').hide();
                                                    gEx('btnModificarAcuerdoV2').hide();
                                                    gEx('btnModificarSituacionAcuerdoV2').hide();
                                                }
        								)
        return 	tblGrid;	
}



function crearGridPenasEjecucion()
{
	var cmbAcogeSustitutivo=crearComboExt('cmbAcogeSustitutivo',arrSiNo,0,0);
	var cmbSustitutivoAcoge=crearComboExt('cmbSustitutivoAcoge',[],0,0);
	var cmbAcogeSuspensionCondicional=crearComboExt('cmbAcogeSuspensionCondicional',arrSiNo,0,0);
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idPena'},
		                                                {name: 'sentenciado'},
		                                                {name:'descripcion'},
		                                                {name:'sustitutivos'},
                                                        {name: 'seAcoge'},
                                                        {name: 'sustitutivoAcoge'},
                                                        {name: 'arrSustitutivo'},
                                                        {name: 'periodoPena'},
                                                        {name: 'seAcogeSuspensionCondicional'},
                                                        {name: 'comentariosAdicionales'},
                                                        {name: 'permiteSuspensionCondicional'},
                                                        {name: 'fechaInicio', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'fechaCompurga', type:'date', dateFormat:'Y-m-d'}
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
                                                            sortInfo: {field: 'sentenciado', direction: 'ASC'},
                                                            groupField: 'sentenciado',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='136';
                                        proxy.baseParams.cA=gE('carpetaAdministrativa').value;
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            
                                                            {
                                                                header:'Sentenciado',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'sentenciado'
                                                            },
                                                            {
                                                                header:'Pena',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'descripcion'
                                                            },
                                                            {
                                                                header:'Sustitutivos concedidos',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'sustitutivos'
                                                            },
                                                            {
                                                                header:'Se acoge a<br> sustitutivo',
                                                                width:80,
                                                                sortable:true,
                                                                editor:cmbAcogeSustitutivo,
                                                                dataIndex:'seAcoge',
                                                                renderer:function(val,meta,registro)
																		{
																			if(registro.data.arrSustitutivo.length==0)
																				return 'N/A';
																			return formatearValorRenderer(arrSiNo,val);
																		}
                                                            },
                                                            {
                                                                header:'Sustitutivos al que se acoge',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'sustitutivoAcoge',
                                                                editor:cmbSustitutivoAcoge,
                                                                renderer:function(val,meta,registro)
																		{
																			return formatearValorRenderer(registro.data.arrSustitutivo,val);
																		}
                                                            },
                                                            {
                                                                header:'Fecha de <br>inicio de pena /<br>Compurga',
                                                                width:100,
                                                                sortable:true,
                                                                editor: {xtype:'datefield'},
                                                                dataIndex:'fechaInicio',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                			if(registro.data.sustitutivoAcoge!='')
																			{
																				var pos=existeValorMatriz(registro.data.arrSustitutivo,registro.data.sustitutivoAcoge);
																				var f=registro.data.arrSustitutivo[pos];
																				

																				if(f[2].length==0)
																				{
																					return 'N/A';
																				}
																			}
																			else
																			{
																				if(registro.data.periodoPena.length==0)
																				{
																					return 'N/A';
																				}
																			}
                                                                			
                                                                			if(val && registro.data.fechaCompurga)
                                                                			{
																						return val.format('d/m/Y')+'<br><b>'+registro.data.fechaCompurga.format('d/m/Y')+'</b>';
                                                                			}
                                                                		}
                                                            },
                                                            {
                                                                header:'Se acoge a la<br>suspenci&oacute;n condicional<br>de la pena?',
                                                                width:140,
                                                                sortable:true,
                                                                editor:cmbAcogeSuspensionCondicional,
                                                                dataIndex:'seAcogeSuspensionCondicional',
                                                                renderer:function(val,meta,registro)
																		{
																			if(registro.data.permiteSuspensionCondicional=='0')
																				return 'N/A';
																			return formatearValorRenderer(arrSiNo,val);
																		}
                                                            },
                                                            {
                                                                header:'Comentarios adicionales',
                                                                width:300,
                                                                sortable:true,
                                                                editor:{xtype:'textarea'},
                                                                dataIndex:'comentariosAdicionales',
                                                                renderer:function(val,meta,registro)
																		{
																			
																			return mostrarValorDescripcion(val);
																		}
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                            {
                                                                id:'gPenasEjecucion',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                height:300,
                                                                clicksToEdit:1,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,  
                                                                title:'Registro de sentencia', 
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
       							
       								if(sLectura)
       								{
										e.cancel=true;
										return;
									}	
       								switch(e.field)
       								{
       									case 'seAcogeSuspensionCondicional':
       										if(e.record.data.permiteSuspensionCondicional=='0')
       											e.cancel=true;
       									break;
       									case 'seAcoge':
       										if(e.record.data.arrSustitutivo.length==0)
       										{
       											e.cancel=true;
       										}
       									break;
       									case 'sustitutivoAcoge':
       										if((e.record.data.arrSustitutivo.length==0)||(e.record.data.seAcoge=='0'))
       										{
       											e.cancel=true;
       										}
       										else
       										{
       											gEx('cmbSustitutivoAcoge').getStore().loadData(e.record.data.arrSustitutivo);
       										}
       									break;
       									case 'fechaInicio':
       										if(e.record.data.sustitutivoAcoge!='')
       										{
       											var pos=existeValorMatriz(e.record.data.arrSustitutivo,e.record.data.sustitutivoAcoge);
       											var f=e.record.data.arrSustitutivo[pos];
       											
       											if(f[2].length==0)
       											{
       												e.cancel=true;
       											}
       										}
       										else
       										{
       											if(e.record.data.periodoPena.length==0)
       											{
       												e.cancel=true;
       											}
       										}
       									
       									
       									break;
       								}
       							}
        			)
        			
        tblGrid.on('afteredit',function(e)
       							{	
       								
       								switch(e.field)
       								{
       									case 'seAcogeSuspensionCondicional':
       										var idSentenciado=e.record.get('sentenciado');
       										
       										var x;
       										var fila;
       										for(x=0;x<e.grid.getStore().getCount();x++)
       										{
       											fila=e.grid.getStore().getAt(x);
       											
       											if((fila.data.sentenciado==idSentenciado)&&(fila.data.permiteSuspensionCondicional=='1'))
       												fila.set('seAcogeSuspensionCondicional',e.value);
       											
       										}
       										
       										
       									break;
       									case 'seAcoge':
       										e.record.set('sustitutivoAcoge','');
       										e.record.set('fechaInicio','');
       										e.record.set('fechaCompurga','');
       										
       										e.record.set('fechaInicio','');
       									break;
       									case 'sustitutivoAcoge':
       										e.record.set('fechaInicio','');
       										e.record.set('fechaCompurga','');
       									break;
       									case 'fechaInicio':
       										var arrPena=[0,0,0];
       										if(e.record.data.sustitutivoAcoge!='')
       										{
       											var pos=existeValorMatriz(e.record.data.arrSustitutivo,e.record.data.sustitutivoAcoge);
       											var f=e.record.data.arrSustitutivo[pos];
       											arrPena=f[2];
       											
       										}
       										else
       										{
       											arrPena=e.record.data.periodoPena;
       											
       										}
       										
       									var fechaTermino=e.value.add(Date.YEAR,parseInt(arrPena[0]));
       									fechaTermino=fechaTermino.add(Date.MONTH,parseInt(arrPena[1]));									
       									fechaTermino=fechaTermino.add(Date.DAY,parseInt(arrPena[2]));
       									
       									e.record.set('fechaCompurga',fechaTermino);	
       									break;
       								}
       							}
        			)			
        			
        			
        			
        return 	tblGrid;
}

function agregarImputadoAcuerdo()
{
	var objConf={};
    var nombreTipo=formatearValorRenderer(arrParteProcesalCP,'4');
    
    
    objConf.ocultaIdentificacion=true;
    objConf.idActividad=gE('idActividad').value;
    objConf.idCarpeta=-1;
    objConf.afterRegister=agregarImputadoComboAcuerdo;
    
	agregarParticipanteVentana('4',nombreTipo,objConf)
    
	
}

function agregarImputadoComboAcuerdo(idImputado,nombre,tipoParticipante,aImputados)
{
	arrImputados=eval(aImputados);
	gEx('cmbImputado').getStore().loadData(arrImputados);
    gEx('cmbImputado').setValue(idImputado);
    window.parent.recargarArbolSujetos();
}

function mostrarVentanaAcuerdoReparatorioV2(fDatosAcuerdo)
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
                                                            xtype:'label',
                                                            html:'Fecha de extinci&oacute;n de la acci&oacute;n penal:'
                                                        },
                                                        {
                                                            x:245,
                                              
                                                            y:5,
                                                            xtype:'datefield',
                                                            id:'dteFechaExticion'
                                                        },
                                                        {
                                                            x:10,
                                                            y:40,
                                                            xtype:'label',
                                                            html:'Comentarios adicionales:'
                                                        },
                                                        {
                                                        	x:245,
                                                            y:35,
                                                            xtype:'textarea',
                                                            width:505,
                                                            height:60,
                                                            id:'txtComentarios'
                                                        },
                                                        {
                                                            x:10,
                                                            y:115,
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
										height:340,
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
															},
                                                    	close: function()
                                                        		{
                                                                	window.parent.mostrarPanelDerecho();
                                                                }
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		
                                                                        var dteFechaExticion=gEx('dteFechaExticion');  
                                                                        var gDocumentosAcuerdos=gEx('gDocumentosAcuerdos');
                                                                        
                                                                        
                                                                       
                                                                        
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
                                                                        
                                                                        datosAcuerdo='{"idRegistro":"'+(fDatosAcuerdo?fDatosAcuerdo.data.idRegistro:-1)+'","idEvento":"'+gE('idEvento').value+
                                                                        				'","fechaExtincion":"'+(dteFechaExticion.getValue()==''?'':dteFechaExticion.getValue().format('Y-m-d'))+
                                                                                		'","documentosAcuerdo":['+listaAcuerdos+'],"comentariosAdicionales":"'+cv(gEx('txtComentarios').getValue())+
                                                                                		'","acuerdoUpdate":"1"}';
                                                                        
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
        gEx('dteFechaExticion').setValue(fDatosAcuerdo.data.fechaExtincionAccionPenal);
    }                                
                                
	ventanaAM.show();
															
}

function mostrarVentanaCambiarSituacionAcuerdo(fDatosAcuerdo)
{
	var cmbSituacionActual=crearComboExt('cmbSituacionActual',arrSituacionAcuerdo,180,5,200);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Situaci&oacute;n actual:'
                                                        },
                                                        cmbSituacionActual,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Comentarios adicionales:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            id:'txtComentariosAdicionales',
                                                            xtype:'textarea',
                                                            width:500,
                                                            height:60
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Cambiar Situaci&oacute;n Acuerdo Reparatorio',
										width: 550,
										height:230,
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
																		if(cmbSituacionActual.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbSituacionActual,focus();
                                                                            }
                                                                            mxgBox('Debe indicar la situaci&oacute;n actual del acuerdo reparatorio',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        var cadObj='{"idAcuerdo":"'+fDatosAcuerdo.data.idRegistro+
                                                                        		'","situacionActual":"'+cmbSituacionActual.getValue()+
                                                                                '","comentariosAdicionales":"'+cv(gEx('txtComentariosAdicionales').getValue())+'"}';
                                                                        
                                                                        
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
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=230&cadObj='+cadObj,true);
                                                                        
                                                                        
                                                                        
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



function verHistorialCambiosAcuerdo(iA)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			crearGridHistorialAcuerdo(iA)
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Historial cambios',
										width: 650,
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
															text: '<?php echo $etj["lblBtnAceptar"]?>',
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


function crearGridHistorialAcuerdo(iA)
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
                                                        {name:'fechaOperacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name:'fechaExtinsionAnterior', type:'date', dateFormat:'Y-m-d'},
		                                                {name:'responsable'},
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
                                                            sortInfo: {field: 'fechaOperacion', direction: 'DESC'},
                                                            groupField: 'fechaOperacion',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='231';
                                        proxy.baseParams.idAcuerdo=bD(iA);

                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            {
                                                                header:'Fecha',
                                                                width:200,
                                                                sortable:true,
                                                                align:'left',
                                                                dataIndex:'fechaOperacion',
                                                                renderer:function(val)
                                                                		{
                                                                        
                                                                        	return formatoTitulo(val.format('d')+' de '+arrMeses[parseInt(val.format('m'))-1][1]+' de '+val.format('Y')+'<br>('+val.format('H:i:s')+' hrs.)');
                                                                        }
                                                            },                                                                                                                      
                                                            {
                                                                header:'Responsable',
                                                                width:350,
                                                                sortable:true,
                                                                align:'right',
                                                                dataIndex:'responsable',
                                                                renderer:formatoTitulo3
                                                            }
                                                            
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                    {
                                                        id:'gridHistorialAcuerdo',
                                                        store:alDatos,
                                                       	region:'center',
                                                        
                                                        height:600,
                                                        frame:false,
                                                        border:true,
                                                        cm: cModelo,
                                                        columnLines : false,
                                                        stripeRows :true,
                                                        loadMask:true,
                                                                                                                        
                                                        view:new Ext.grid.GroupingView({
                                                                                            forceFit:false,
                                                                                            showGroupName: false,
                                                                                            enableGrouping :false,
                                                                                            enableNoGroups:false,
                                                                                            enableGroupingMenu:false,
                                                                                            hideGroupedColumn: false,
                                                                                            startCollapsed:false,
                                                                                            enableRowBody:true,
                                                                                            getRowClass : formatearFilaHistorial
                                                                                        })
                                                    }
                                                );
        return 	tblGrid;	
}

function formatearFilaHistorial(record, rowIndex, p, ds)
{
	var xf = Ext.util.Format;
    p.body = 	'<BR><table width="100%"><tr><td width="30"></td><td width="200"><span style="color: #001C02"><b>Fecha de extinci&oacute;n de la acci&oacute;n penal:</b></span><br><br><span style="color: #3B3C3B"></td><td width="300">'+record.data.fechaExtinsionAnterior.format('d/m/Y')+'</td></tr>'+
    			'<tr><td></td><td conspan="2"><span style="color: #001C02"><b>Comentarios adicionales:</b></span><br><br><span style="color: #3B3C3B">' + ((record.data.comentariosAdicionales.trim()=="")?"(Sin comentarios)":record.data.comentariosAdicionales) + '</span></td></tr></table><br><br><br>';
    return 'x-grid3-row-expanded';
}

function formatoTitulo(val)
{
	return '<span style="font-size:11px; color:#040033">'+val+'</span>';
}

function formatoTitulo2(val)
{
	return '<div style="font-size:11px; color:#040033;; height:45px; word-wrap: break-word;white-space: normal; ">'+val+'</div>';
}

function formatoTitulo3(val)
{
	return '<div style="font-size:11px; height:45px; color:#040033; word-wrap: break-word;white-space: normal;"><img src="../images/user_gray.png">'+(val)+'</div>';
}

function verHistorialSituacionAcuerdo(iA)
{
	mostrarBitacoraSituacionObjeto('2',bD(iA),arrSituacionAcuerdo,'Historial de Situaci&oacute;n de Acuerdo');
}


function visualizarDocumento(iD,nombreDoc)
{
	var arrNombre=bD(nombreDoc).split('.');
	window.parent.mostrarVisorDocumentoProceso(arrNombre[arrNombre.length-1].toLowerCase(),bD(iD),{});
}

function removerDocumento(iD)
{
	var objConf={};
    objConf.tipoObjeto='3';
    objConf.idRegistro=bD(iD);
    objConf.situacionActual=1;
    objConf.leyendaComentario='Ingrese el motivo de la baja del documento:';
    objConf.tituloVentana='Remover documento';
    objConf.comentarioObligatorio=true;
    objConf.solicitarConfirmacion=true;
    objConf.lenyedaConfirmacion='Est&aacute; seguro de querer remover el documento seleccionado?';
    objConf.funcAfterChange=function()
    				{
                    	gE('fDocumento_'+bD(iD)).parentNode.removeChild(gE('fDocumento_'+bD(iD)));
                    }
	
    
    
    mostrarVentanaCambioSituacionObjetoComentario(objConf);
}


function mostrarVentanaCambiarSituacionMedidaCautelar(fRegistro)
{
	var cmbSituacionActual=crearComboExt('cmbSituacionActual',arrSituacionAcuerdo,180,5,200);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Situaci&oacute;n actual:'
                                                        },
                                                        cmbSituacionActual,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Comentarios adicionales:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            id:'txtComentariosAdicionales',
                                                            xtype:'textarea',
                                                            width:500,
                                                            height:60
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Cambiar Situaci&oacute;n Medida Cautelar',
										width: 550,
										height:230,
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
																		if(cmbSituacionActual.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbSituacionActual,focus();
                                                                            }
                                                                            mxgBox('Debe indicar la situaci&oacute;n actual de la Medida Cautelar',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        var cadObj='{"idRegistro":"'+fRegistro.data.idRegistroMedida+
                                                                        		'","situacionActual":"'+cmbSituacionActual.getValue()+
                                                                                '","comentariosAdicionales":"'+
                                                                                cv(gEx('txtComentariosAdicionales').getValue())+'","tipoObjeto":"4"}';
                                                                        
                                                                        
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
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_BitacoraObjeto.php',funcAjax, 'POST','funcion=2&cadObj='+cadObj,true);
                                                                        
                                                                        
                                                                        
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


function mostrarVentanaCambiarSituacionMedidaProteccion(fRegistro)
{
	var cmbSituacionActual=crearComboExt('cmbSituacionActual',arrSituacionAcuerdo,180,5,200);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Situaci&oacute;n actual:'
                                                        },
                                                        cmbSituacionActual,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Comentarios adicionales:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            id:'txtComentariosAdicionales',
                                                            xtype:'textarea',
                                                            width:500,
                                                            height:60
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Cambiar Situaci&oacute;n Medida Protecci&oacute;n',
										width: 550,
										height:230,
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
																		if(cmbSituacionActual.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbSituacionActual,focus();
                                                                            }
                                                                            mxgBox('Debe indicar la situaci&oacute;n actual de la Medida de Protecci&oacute;n',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        var cadObj='{"idRegistro":"'+fRegistro.data.idRegistroMedida+
                                                                        		'","situacionActual":"'+cmbSituacionActual.getValue()+
                                                                                '","comentariosAdicionales":"'+
                                                                                cv(gEx('txtComentariosAdicionales').getValue())+'","tipoObjeto":"5"}';
                                                                        
                                                                        
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
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_BitacoraObjeto.php',funcAjax, 'POST','funcion=2&cadObj='+cadObj,true);
                                                                        
                                                                        
                                                                        
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

function mostrarVentanaCambiarSituacionSuspensionCondicional(fRegistro)
{
	var cmbSituacionActual=crearComboExt('cmbSituacionActual',arrSituacionAcuerdo,180,5,200);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Situaci&oacute;n actual:'
                                                        },
                                                        cmbSituacionActual,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Comentarios adicionales:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            id:'txtComentariosAdicionales',
                                                            xtype:'textarea',
                                                            width:500,
                                                            height:60
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Cambiar Situaci&oacute;n de Suspensi&oacute;n Condicional',
										width: 550,
										height:230,
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
																		if(cmbSituacionActual.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbSituacionActual,focus();
                                                                            }
                                                                            mxgBox('Debe indicar la situaci&oacute;n actual de la Suspensi&oacute;n Condicional',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        var cadObj='{"idRegistro":"'+fRegistro.data.idRegistroMedida+
                                                                        		'","situacionActual":"'+cmbSituacionActual.getValue()+
                                                                                '","comentariosAdicionales":"'+
                                                                                cv(gEx('txtComentariosAdicionales').getValue())+'","tipoObjeto":"6"}';
                                                                        
                                                                        
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
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_BitacoraObjeto.php',funcAjax, 'POST','funcion=2&cadObj='+cadObj,true);
                                                                        
                                                                        
                                                                        
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


function verHistorialSituacionMedida(iA)
{
	mostrarBitacoraSituacionObjeto('4',bD(iA),arrSituacionAcuerdo,'Historial de Situaci&oacute;n de Medida Cautelar');
}



function verHistorialSituacionMedidaProteccion(iA)
{
	mostrarBitacoraSituacionObjeto('5',bD(iA),arrSituacionAcuerdo,'Historial de Situaci&oacute;n de Medida de Protecci&oacute;n');
}


function verHistorialSituacionSuspencionCondicional(iA)
{
	mostrarBitacoraSituacionObjeto('6',bD(iA),arrSituacionAcuerdo,'Historial de Situaci&oacute;n de Suspensi&oacute;c Condicional');
}


function agregarImputado(tGrid)
{
	var objConf={};
    var nombreTipo=formatearValorRenderer(arrParteProcesalCP,'4');
    
    
    objConf.ocultaIdentificacion=true;
    objConf.idActividad=gE('idActividad').value;
    objConf.idCarpeta=-1;
    objConf.afterRegister=agregarImputadoComboAcuerdo;
    
	agregarParticipanteVentana('4',nombreTipo,objConf)
    
	
}

function mostrarVentanaAgregarResolutivo(fila)
{
	idResolutivo=-1;
    tipoResultado='';
    registroSeleccionado=null;
	var oConf=	{
    					idCombo:'cmbResolutivo',
                        anchoCombo:400,
                        posX:110,
                        posY:5,
                        raiz:'registros',
                        campoDesplegar:'resolutivo',
                        campoID:'idResolutivo',
                        funcionBusqueda:232,
                        paginaProcesamiento:'../paginasFunciones/funcionesModulosEspeciales_SGP.php',
                        confVista:'<tpl for="."><div class="search-item">{resolutivo}<br></div></tpl>',
                        campos:	[
                                   	{name:'idResolutivo'},
                                    {name:'resolutivo'},
                                    {name: 'tipoResultado'},
                                    {name: 'opciones'}

                                ],
                       	funcAntesCarga:function(dSet,combo)
                    				{
                                    	idResolutivo=-1;
                                    	var aValor=combo.getRawValue();
										dSet.baseParams.criterio=aValor;
                                        dSet.baseParams.idEvento=gE('idEvento').value;  
                                                                              
                                        
                                    },
                      	funcElementoSel:funcResolutivoSel
    				};

	var cmbResolutivo=crearComboExtAutocompletar(oConf);
    
    var cmbSiNoResolutivo=crearComboExt('valorResultado_1',arrSiNo,530,5,150);
    cmbSiNoResolutivo.hide();
    
    var cmbAudienciasCarpeta=crearComboExt('valorResultado_3',arrAudiencias,530,5,200);
    cmbAudienciasCarpeta.hide();
    var cmbCarpetasJudiciales=crearComboExt('valorResultado_6',arrCarpetasAdministrativas,530,5,200);
    cmbCarpetasJudiciales.hide();
    var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Resolutivo:'
                                                        },
                                                        cmbResolutivo,
                                                        cmbSiNoResolutivo,
                                                        {
                                                        	xtype:'datefield',
                                                            id:'valorResultado_4',
                                                            x:530,
                                                            hidden:true,
                                                            y:5
                                                        },
                                                        {
                                                        	xtype:'numberfield',
                                                            id:'valorResultado_5',
                                                            x:530,
                                                            width:150,
                                                            allowDecimals:true,
                                                            allowNegative:false,
                                                            hidden:true,
                                                            y:5
                                                        },
                                                        cmbAudienciasCarpeta,
                                                        cmbCarpetasJudiciales,
                                                        {
                                                        	xtype:'fieldset',
                                                            width:740,
                                                            height:170,
                                                            x:0,
                                                            y:35,
                                                            hidden:true,
                                                            id:'valorResultado_2',
                                                            border:true,
                                                            title:'Periodo',
                                                            layout:'absolute',
                                                            items:	[
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
                                                                            x:270,
                                                                            y:100
                                                                        },
                                                                        {
                                                                            xtype:'datefield',
                                                                            id:'txtFechaResultado',
                                                                            x:390,
                                                                            y:95,
                                                                            disabled:true,
                                                                            value:fechaEvento
                                                                        }
                                                            		]
                                                        },
                                                        {
                                                        	xtype:'fieldset',
                                                            width:740,
                                                            height:115,
                                                            x:0,
                                                            y:35,
                                                            border:true,
                                                            layout:'absolute',
                                                            id:'field_Comentarios',
                                                            title:'Comentarios adicionales',
                                                            items:	[
                                                            			
                                                                        {
                                                                        	x:0,
                                                                            y:5,
                                                                            id:'txtComentariosAdicionales',
                                                                            xtype:'textarea',
                                                                            value:fila?escaparBR(fila.data.comentariosAdicionales):'',
                                                                            width:710,
                                                                            height:70
                                                                        }
                                                            		]
                                                        }
                                                        ,
                                                        {
                                                        	xtype:'fieldset',
                                                            width:740,
                                                            height:170,
                                                            x:0,
                                                            y:40,
                                                            id:'valorResultado_8',
                                                            border:true,
                                                            hidden:true,
                                                            title:'Seleccione al imputado involucrado',
                                                            layout:'absolute',
                                                            items:	[
                                                            			crearGridOpciones(8)
                                                            		]
                                                        }
                                                        ,
                                                        {
                                                        	xtype:'fieldset',
                                                            width:740,
                                                            height:170,
                                                            x:0,
                                                            y:40,
                                                            hidden:true,
                                                            title:'Seleccione las opciones que apliquen',
                                                            id:'valorResultado_9',
                                                            border:true,
                                                            layout:'absolute',
                                                            items:	[
                                                            			crearGridOpciones(9)
                                                            		]
                                                        }
                                                        
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar resolutivo',
										width: 770,
										height:420,
										layout: 'fit',
										plain:true,
										modal:true,
                                        id:'vResolutivo',
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
                                                        show : {
                                                                    buffer : 10,
                                                                    fn : function() 
                                                                    {
                                                                        gEx('cmbResolutivo').focus(false,500);
                                                                        gEx('vResolutivo').setHeight(240);
                                                                        
                                                                        if(fila)
                                                                        {

                                                                            cmbResolutivo.setRawValue(fila.data.resolutivo);
                                                                            var registro=crearRegistro(	[
                                                                                                            {name:'idResolutivo'},
                                                                                                            {name:'resolutivo'},
                                                                                                            {name: 'tipoResultado'},
                                                                                                            {name: 'opciones'}
                                                                                                        ]);
                                                                            var r=new registro	(
                                                                                                    {
                                                                                                        idResolutivo:fila.data.idResolutivo,
                                                                                                        resolutivo:fila.data.resolutivo,
                                                                                                        tipoResultado:fila.data.tipoValor,
                                                                                                        opciones:fila.data.opciones
                                                                                                    }
                                                                                                )
                                                                                                
                                                                            funcResolutivoSel(cmbResolutivo,r);  
                                                                            
																			var tipoValor=fila.data.tipoValor;
                                                                            if(tipoValor=='10')
                                                                            {
                                                                            	tipoValor='9';
                                                                            }
                                                                            if((tipoValor=='2')||(tipoValor=='8')||(tipoValor=='9'))
                                                                            {
                                                                                if(fila.data.tipoValor=='2')
                                                                                {
                                                                                	var objConf=eval('['+fila.data.valor+']')[0];
                                                                                    gEx('dteFechaBase').setValue(objConf.fechaBase);
                                                                                    gEx('txtAnos').setValue(objConf.anios);
                                                                                    gEx('txtMeses').setValue(objConf.meses);
                                                                                    gEx('txtDias').setValue(objConf.dias);
                                                                                    gEx('txtFechaResultado').setValue(objConf.fechaFinal);
                                                                                }
                                                                                else
                                                                                {
                                                                                	
                                                                                    var arrDatos=[];

                                                                                    var arrValores=fila.data.opcionesSeleccionadas;
                                                                                    
                                                                                    switch(tipoResultado)
                                                                                    {
                                                                                        case '8':
                                                                                            arrDatos=arrImputados;
                                                                                        break;
                                                                            
                                                                                        case '9':
                                                                                            
                                                                                            arrDatos=fila.data.opciones;
                                                                                        break;
                                                                                        case '10':
                                                                                            
                                                                                            arrDatos=fila.data.opciones;
                                                                                        break;
                                                                                    }
                                                                                   
                                                                                    var x;
                                                                                    
                                                                                    var seleccionado='';
                                                                                    var comentariosAdicionales='';
                                                                                    var pos='';
                                                                                    var dsDatos=[];                                                                                    
                                                                                   
                                                                                    for(x=0;x<arrDatos.length;x++)
                                                                                    {
                                                                                        seleccionado=false;
                                                                                        comentariosAdicionales='';
                                                                                        pos=existeValorMatriz(arrValores,arrDatos[x][0]);
                                                                                        if(pos!=-1)
                                                                                        {
                                                                                        	seleccionado=true;
                                                                                            comentariosAdicionales=arrValores[pos][1];
                                                                                        }
                                                                                        
                                                                                        dsDatos.push([arrDatos[x][0],arrDatos[x][1],seleccionado,comentariosAdicionales]);
                                                                                    }
                                                                                    console.log(dsDatos);
                                                                                    gEx('gOpciones_'+tipoResultado).getStore().loadData(dsDatos);
                                                                                
                                                                                
                                                                                }
                                                                            }
                                                                            else
                                                                            {
                                                                                if(gEx('valorResultado_'+fila.data.tipoValor))
                                                                                {
                                                                                    gEx('valorResultado_'+fila.data.tipoValor).setValue(fila.data.valor);
                                                                                }
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
                                                                        var valor='';
                                                                        var opciones='';
                                                                        if((tipoResultado=='2')||(tipoResultado=='8')||(tipoResultado=='9'))
                                        								{
                                                                        	if(tipoResultado=='2')
                                                                            {
                                                                            	valor='{"fechaBase":"'+gEx('dteFechaBase').getValue().format('Y-m-d')+
                                                                                        '","anios":"'+gEx('txtAnos').getValue()+'","meses":"'+gEx('txtMeses').getValue()+
                                                                                        '","dias":"'+gEx('txtDias').getValue()+'","fechaFinal":"'+
                                                                                        gEx('txtFechaResultado').getValue().format('Y-m-d')+'"}';
                                                                            }
                                                                            else
                                                                            {
                                                                            	valor='';
                                                                                var x;
                                                                                var grid=gEx('gOpciones_'+tipoResultado);
                                                                                var filaSel;
                                                                                var o='';
                                                                                for(x=0;x<grid.getStore().getCount();x++)
                                                                                {
                                                                                	filaSel=grid.getStore().getAt(x);
                                                                                    
                                                                                    if(filaSel.data.seleccionado)
                                                                                    {
                                                                                    	o='{"idRegistro":"'+filaSel.data.idRegistro+
                                                                                        	'","descripcion":"'+cv(filaSel.data.comentariosAdicionales)+
                                                                                            '"}';	
                                                                                        if(opciones=='')
                                                                                        	opciones=o;
                                                                                        else
                                                                                        	opciones+=','+o;
                                                                                    }
                                                                                }
                                                                                if(opciones=='')
                                                                                {
                                                                                	msgBox('Debe seleccionar almenos una opci&oacuten; como resultado del resolutivo');
                                                                                    return;
                                                                                }
                                                                                
                                                                                
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                        	if(gEx('valorResultado_'+tipoResultado))
                                                                            {
                                                                        		valor=gEx('valorResultado_'+tipoResultado).getValue();
                                                                                
                                                                                if(valor=='')
                                                                                {
                                                                                    function resp()
                                                                                    {
                                                                                        gEx('valorResultado_'+tipoResultado).focus();
                                                                                    }
                                                                                    msgBox('Debe ingresar el valor de resultado',resp);
                                                                                    return;
                                                                                }
                                                                                
                                                                            }
                                                                        }
                                                                        
                                                                        
                                                                        if(valor.format)
                                                                            valor=valor.format('Y-m-d');
                                                                        o='{"idResolutivo":"'+idResolutivo+'","valor":"'+cv(valor)+
                                                                        	'","comentariosAdicionales":"'+cv(gEx('txtComentariosAdicionales').getValue())+
                                                                            '","opciones":['+opciones+']}';
                                                                        
                                                                        var obj='{"idEvento":"'+gE('idEvento').value+'","resolutivo":'+o+',"arrPenas":[]}';
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('gridResolutivos').getStore().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=233&cadObj='+obj,true);
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

function funcResolutivoSel(combo,registro)
{
	
    idResolutivo=registro.data.idResolutivo;
    registroSeleccionado=registro;
    tipoResultado=registro.data.tipoResultado;

    if(tipoResultado=='10')	
        tipoResultado='9' ;                                       	
    var x;
    for(x=1;x<10;x++)
    {
        if(gEx('valorResultado_'+x))
            gEx('valorResultado_'+x).hide();
    }
    
    if(gEx('valorResultado_'+tipoResultado))
    {
        gEx('valorResultado_'+tipoResultado).show();
        
    }


    if((tipoResultado=='2')||(tipoResultado=='8')||(tipoResultado=='9'))
    {

        gEx('vResolutivo').setHeight(420);
        
        gEx('field_Comentarios').setPosition(0,215);	
        
        var arrDatos=[];

        var arrValores=[];
        
        switch(tipoResultado)
        {
        	case '8':
	            arrDatos=arrImputados;
            break;

        	case '9':
	            gEx('valorResultado_9').setTitle('Seleccione la opci&oacute;n que aplique');
	            arrDatos=registro.data.opciones;
            break;
            case '10':
				gEx('valorResultado_9').setTitle('Seleccione las opciones que apliquen');
	            arrDatos=registro.data.opciones;
            break;
        }
		
        
        gEx('gOpciones_'+tipoResultado).tipoResultado=registro.data.tipoResultado;
        var x;
    

        
        var seleccionado='';
        var comentariosAdicionales='';
        var pos='';
        var dsDatos=[];
        for(x=0;x<arrDatos.length;x++)
        {
            seleccionado=false;
            comentariosAdicionales='';
            dsDatos.push([arrDatos[x][0],arrDatos[x][1],seleccionado,comentariosAdicionales]);
        }
        
        gEx('gOpciones_'+tipoResultado).getStore().loadData(dsDatos);
        
        
    }
    else
    {
        
        gEx('vResolutivo').setHeight(240);
        gEx('field_Comentarios').setPosition(0,35);	
    }
    
    if(gEx('gOpciones_'+tipoResultado))
        gEx('gOpciones_'+tipoResultado).getView().refresh();
}  

function crearGridOpciones(tipo)
{
	var dsDatos=[];
    
    
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idRegistro'},
                                                                    {name: 'descripcion'},
                                                                    {name: 'seleccionado'},
                                                                    {name: 'comentariosAdicionales'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	var checkColumn = new Ext.grid.CheckColumn	(
	 												{
													   header: '',
													   dataIndex: 'seleccionado',
													   width: 50
													}
												);
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														checkColumn,
														{
															header:'',
															width:250,
															sortable:true,
															dataIndex:'descripcion'
														},
														{
															header:'Comentarios',
															width:320,
															sortable:true,
                                                            renderer:function(val)
                                                            		{
                                                                    	return val;
                                                                    },
                                                            editor:	{
                                                            			xtype:'textarea',
                                                                        height:60
                                                            		},
															dataIndex:'comentariosAdicionales'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:false,
                                                            y:0,
                                                            id:'gOpciones_'+tipo,
                                                            clicksToEdit:1,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            plugins:[checkColumn],
                                                            columnLines : true,
                                                            height:125,
                                                            width:710
                                                            
                                                        }
                                                    );
	
    tblGrid.on('beforeedit',function(e)
    						{
                            	
                            	if((e.field=='comentariosAdicionales' )&&(!e.record.data.seleccionado))
                                	e.cancel=true;

                                	
								if((e.field=='seleccionado' )&&(!e.value)&&(gEx('gOpciones_'+tipo).tipoResultado)&&(gEx('gOpciones_'+tipo).tipoResultado=='9'))
                                {
                                	
                                	var x;
                                    var fila;
                                    for(x=0;x<gEx('gOpciones_'+tipo).getStore().getCount();x++)
                                    {
                                    	fila=gEx('gOpciones_'+tipo).getStore().getAt(x);
                                        fila.set('seleccionado',false);
                                        fila.set('comentariosAdicionales','');
                                    }
                                    e.record.set('seleccionado',true);
                                }                                    
                                    
                            }
    			)
    
    tblGrid.on('afteredit',function(e)
    						{
                            	if((e.field=='seleccionado' )&&(!e.value))
                                	e.record.set('comentariosAdicionales','');
                            }
    			)						
    
    return 	tblGrid;
}

