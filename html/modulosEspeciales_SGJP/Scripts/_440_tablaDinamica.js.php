<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$iF=bD($_GET["iF"]);
	$iR=bD($_GET["iR"]);
	$iRef=$_GET["iRef"];
	
	$consulta="SELECT idReferencia FROM _294_tablaDinamica WHERE id__294_tablaDinamica=".$iRef;
	$idReferenciaAsuntos=$con->obtenerValor($consulta);
	
	
	$consulta="SELECT procesoPendiente,especifiqueProcesoPendiente FROM _358_tablaDinamica WHERE idReferencia=".$idReferenciaAsuntos;
	$fProcesosPendientes=$con->obtenerPrimeraFila($consulta);
	$lblProcesos="(NINGUNO)";
	if($fProcesosPendientes[0]==1)
	{
		$lblProcesos=$fProcesosPendientes[1];
	}
	
	$consulta="SELECT eventoAudiencia FROM _294_tablaDinamica WHERE id__294_tablaDinamica=".$iRef;
	$idEvento=$con->obtenerValor($consulta);
	
	$consulta="SELECT valor,texto FROM 1004_siNo";
	$arrSiNo=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT carpetaAdministrativa  FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 AND idRegistroContenidoReferencia=".$idEvento;
	$cAdministrativa=$con->obtenerValor($consulta);
	
	$consulta="SELECT unidadGestion,idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cAdministrativa."'";
	$fDatosCarpeta=$con->obtenerPrimeraFila($consulta);
	$unidadGestion=$fDatosCarpeta[0];
	$idActividad=$fDatosCarpeta[1];
	
	$consulta="SELECT carpetaAdministrativa,carpetaAdministrativa FROM 7006_carpetasAdministrativas 
				WHERE unidadGestion='".$unidadGestion."'";//."' and carpetaAdministrativa<>'".$cAdministrativa."'"
	$arrCarpetasAdministrativas=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__47_tablaDinamica,CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno)
				,' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno)) AS nombre FROM 7005_relacionFigurasJuridicasSolicitud r,
				_47_tablaDinamica p WHERE r.idActividad=".$idActividad." AND r.idFiguraJuridica=4 
				AND p.id__47_tablaDinamica=r.idParticipante";

	$arrImputados=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT horaInicioEvento FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$idEvento;
	$horaEvento=$con->obtenerValor($consulta);
	
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
?>
var arrCarpetasAdministrativas=<?php echo $arrCarpetasAdministrativas?>;
var arrSiNo=<?php echo $arrSiNo?>;
var arrImputados=<?php echo $arrImputados?>;
var idEvento=<?php echo $idEvento?>;
var arrTotalAudiencia=[<?php echo $arrTotalAudiencia?>];
var lblProcesos ='<?php echo cv($lblProcesos)?>';
Ext.onReady(inicializar);

function inicializar()
{
	
	if(esRegistroFormulario())
    {
    	
    	
    }
    else
    {
    	if(gE('sp_6973').innerHTML=='Entrega de imputado/sentenciado a procesales')
        {
        	oE('div_6978');
            oE('div_7018');
        }
        else
        {
        	oE('div_6974');
            
            oE('div_7162');
            oE('div_7161');
            
            
    	}
        
        
        if(gE('sp_6975').innerHTML=='Sano')
        {
        	oE('div_7161');
            oE('div_7162');
    	}
    }
    
    gE('_lbl7164').innerHTML='';
    gE('_lbl7166').innerHTML=lblProcesos;
    
   	crearGridAccionesResolutivos();
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
                                        proxy.baseParams.iE=idEvento;
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
                                                                                    
                                                                                    return comp;	
                                                                                    
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
                                                                renderTo:'_lbl7164',
                                                                frame:false,
                                                                height:450,
                                                                width:800,
                                                                clicksToEdit:1,
                                                                cm: cModelo,
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                plugins:[checkColumn],
                                                                columnLines : false,     
                                                                                                                           
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
                            	
                                	e.cancel=true;
                                
                                
                            	
                            }
    			)                                                        
                                                        
        return 	tblGrid;
	
}

   
   