<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	include_once("SIUGJ/libreriaFuncionesIntegraciones.php");
	
	
	$idFormulario=$_GET["iF"];
	$idRegistro=$_GET["iR"];
	
	$arrTipoCambios="";
	$fechaActual=date("Y-m-d");
	$arrCamposDivisas="";
	$arrModenas="";
	$arrColumnas="";
	
	$consulta="SELECT valor FROM 20010_ejecucionLiquidacionParametros WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro.
					" AND nombreParametro='[FechaBaseCambioDivisa]'";
	$fechaBaseCambioDivisa=$con->obtenerValor($consulta);
	if($fechaBaseCambioDivisa=="")
		$fechaBaseCambioDivisa=$fechaActual;
	$consulta="SELECT valor,contenido FROM 902_opcionesFormulario WHERE idGrupoElemento=16388 ORDER BY valor";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_assoc($res))
	{
		$valorCambio="";
		
		if($idFormulario==-1)
			$valorCambio=getCambioMoneda($fechaActual,$fila["valor"]);
		else
		{
			$consulta="SELECT valor FROM 20010_ejecucionLiquidacionParametros WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro.
					" AND nombreParametro='[".$fila["valor"]."]'";
			$valorCambio=$con->obtenerValor($consulta);
			if($valorCambio=="")
				$valorCambio=getCambioMoneda($fechaActual,$fila["valor"]);
			
		
		}
		$o="{name: 'moneda_".$fila["valor"]."'}";
		$arrModenas.=",".$o;
		
		if($arrTipoCambios=="")
			$arrTipoCambios="['".$fila["valor"]."','".cv($fila["contenido"])."']";
		else
			$arrTipoCambios.=",['".$fila["valor"]."','".cv($fila["contenido"])."']";
		
		$arrColumnas.="	,{
							header:'".$fila["contenido"]."',
							width:150,
							sortable:true,
							align:'left',
							dataIndex:'moneda_".$fila["valor"]."',
							renderer:function(val,meta,registro)
									{
										meta.attr='style=\"text-align:right;\"';
										if(registro.data.formatoPresentacion=='3')
										{
											if(isNaN(val))
											{
												val=0;
											}
											return Ext.util.Format.usMoney(val);
										}
										return '---';
										
										
									}
						}";
		
	
		$arrCamposDivisas.=	",{xtype:'label',html:'<div class=\"letraNombreTablero\">".$fila["contenido"].":&nbsp;&nbsp;</div>'},{enableKeyEvents:true,maskRe:/^[0-9.-]$/,xtype:'textfield', listeners:{change:divisaActualizada},id:'txtCambio_".$fila["valor"]."', value:Ext.util.Format.usMoney(".$valorCambio."), width:140,cls:'controlSIUGJ'},{xtype:'tbspacer',width:15}";
	}
	
?>

var fechaBaseCambioDivisa='<?php echo $fechaBaseCambioDivisa?>';
var idFormulario=<?php echo $idFormulario?>;
var idRegistro=<?php echo $idRegistro?>;
var arrTipoCambios=[<?php echo $arrTipoCambios?>];
var arrResultado=[
                    {name: 'idCalculo'},
                    {name: 'etiqueta'},
                    {name: 'resultado'},
                    {name: 'formatoPresentacion'}
                    <?php
						echo $arrModenas;
					?>
                ]
                
var regResultado;                
var arrTiposEntrada=[['1','Valor Entero'],['2','Valor Decimal'],['3','Moneda'],['4','Fecha'],['5','Opciones Cerradas (Combo)'],['6','Opci\xF3n M\xFAltiple (Combo)']];
 
Ext.onReady(inicializar);

function inicializar()
{
	regResultado=crearRegistro(arrResultado); 
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                cls:'panelSiugj',
                                                id:'panelGeneral',
                                                items:	[
                                                			{
                                                            	xtype:'tabpanel',
                                                                region:'center',
                                                                id:'panelGlobal',

                                                                cls:'tabPanelSIUGJ',
                                                                tbar:	[
                                                                            {
                                                                                html:'<span class="SIUGJ_Etiqueta"><b>Concepto de Liquidaci&oacute;n:</b>&nbsp;&nbsp;&nbsp;</span><span class="SIUGJ_ControlEtiqueta">'+gE('nombrePerfil').value+'</b></span>  '
                                                                            },
                                                                             {
                                                                                xtype:'tbspacer',
                                                                                width:20
                                                                            },
                                                                            {
                                                                                icon:'../images/icon_big_tick.gif',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Calcular',
                                                                                handler:function()
                                                                                        {
                                                                                        	aplicarCalculosConceptos()
                                                                                        }
                                                                                
                                                                            },
                                                                            {
                                                                                xtype:'tbspacer',
                                                                                width:20
                                                                            },
                                                                            {
                                                                                icon:'../images/script_go.png',
                                                                                cls:'x-btn-text-icon',
                                                                                id:'btnExportar',
                                                                                hidden:true,
                                                                                text:'Exportar resultado...',
                                                                                menu:	[
                                                                                			{
                                                                                                cls:'x-btn-text-icon',
                                                                                                text:'Formato Excel',
                                                                                                handler:function()
                                                                                                        {
                                                                                                        	var arrParametros='';
	                                                                                                        var gParametros=gEx('gParametros');
                                                                                                            var x;
                                                                                                            var fila;
                                                                                                            var o='';
                                                                                                            for(x=0;x<gParametros.getStore().getCount();x++)
                                                                                                            {
                                                                                                            	fila=gParametros.getStore().getAt(x);
                                                                                                                o='{"parametro":"'+fila.data.etiqueta+'","valor":"'+formatearValorParametro(fila.data.valor,null,fila)+'"}';
                                                                                                                if(arrParametros=='')
                                                                                                                	arrParametros=o;
                                                                                                                else
                                                                                                                	arrParametros+=','+o;
                                                                                                                
                                                                                                            }
                                                                                                            var gResultados=gEx('gResultados');
                                                                                                            var arrCalculos='';
                                                                                                            var lConceptos='';
                                                                                                            var valorConcepto='';
                                                                                                            var pos;
                                                                                                            for(x=0;x<gResultados.getStore().getCount();x++)
                                                                                                            {
                                                                                                            	fila=gResultados.getStore().getAt(x);
                                                                                                                lConceptos='';
                                                                                                               
                                                                                                                for(pos=0;pos<arrTipoCambios.length;pos++)
                                                                                                                {
                                                                                                                    
                                                                                                                    valorConcepto=fila.get('moneda_'+arrTipoCambios[pos][0]);
                                                                                                                    
                                                                                                                    if(valorConcepto!='---')	
                                                                                                                    	valorConcepto=Ext.util.Format.usMoney(valorConcepto);
                                                                                                                        
                                                                                                                	lConceptos+=',"moneda_'+arrTipoCambios[pos][0]+'":"'+valorConcepto+'"'    
                                                                                                                }
                                                                                                                
                                                                                                                o='{"calculo":"'+fila.data.etiqueta+'","valor":"'+cv(fila.data.resultado,false,true)+'"'+lConceptos+'}';
                                                                                                                if(arrCalculos=='')
                                                                                                                	arrCalculos=o;
                                                                                                                else
                                                                                                                	arrCalculos+=','+o;
                                                                                                                
                                                                                                            }
                                                                                                           	
                                                                                                            
                                                                                                            var aTiposCambio='';
                                                                                                            for(pos=0;pos<arrTipoCambios.length;pos++)
                                                                                                            {
                                                                                                                tCambios='{"tipoMoneda":"'+arrTipoCambios[pos][0]+'","etiquetaDivisa":"'+arrTipoCambios[pos][1]+'","tipoCambio":"'+gEx('txtCambio_'+arrTipoCambios[pos][0]).getValue()+'"}';
                                                                                                                if(aTiposCambio=='')
                                                                                                                	aTiposCambio=tCambios;
                                                                                                                else
                                                                                                                	aTiposCambio+=','+tCambios;
                                                                                                                 
                                                                                                            }
                                                                                                            
                                                                                                            
                                                                                                            var cadObj='{"nombreConcepto":"'+cv(gE('nombrePerfil').value,false,true)+'","tipoReporte":"1","arrParametros":['+
                                                                                                            	arrParametros+'],"arrCalculos":['+arrCalculos+'],"arrTiposCambio":['+aTiposCambio+'],"fechaCambioDivisa":"'+gEx('dteFechaCambioDivisa').getValue().format('Y-m-d')+'"}';
                                                                                                        	
                                                                                                            var aParams=[['cadObj',bE(cadObj)]];
                                                                                                        	enviarFormularioDatosV('../reportes/liquidador/reporteCalculo.php',aParams,'POST');
                                                                                                            
                                                                                                        }
                                                                                                
                                                                                            },'-',
                                                                                            {
                                                                                                cls:'x-btn-text-icon',
                                                                                                text:'Formato PDF',
                                                                                                handler:function()
                                                                                                        {
                                                                                                            var arrParametros='';
	                                                                                                        var gParametros=gEx('gParametros');
                                                                                                            var x;
                                                                                                            var fila;
                                                                                                            var o='';
                                                                                                            for(x=0;x<gParametros.getStore().getCount();x++)
                                                                                                            {
                                                                                                            	fila=gParametros.getStore().getAt(x);
                                                                                                                o='{"parametro":"'+fila.data.etiqueta+'","valor":"'+formatearValorParametro(fila.data.valor,null,fila)+'"}';
                                                                                                                if(arrParametros=='')
                                                                                                                	arrParametros=o;
                                                                                                                else
                                                                                                                	arrParametros+=','+o;
                                                                                                                
                                                                                                            }
                                                                                                            var pos;
                                                                                                            var gResultados=gEx('gResultados');
                                                                                                            var arrCalculos='';
                                                                                                            var lConceptos='';
                                                                                                            for(x=0;x<gResultados.getStore().getCount();x++)
                                                                                                            {
                                                                                                            	fila=gResultados.getStore().getAt(x);
                                                                                                                lConceptos='';
                                                                                                               
                                                                                                                for(pos=0;pos<arrTipoCambios.length;pos++)
                                                                                                                {
                                                                                                                    
                                                                                                                    valorConcepto=fila.get('moneda_'+arrTipoCambios[pos][0]);
                                                                                                                    if(valorConcepto!='---')	
                                                                                                                    	valorConcepto=Ext.util.Format.usMoney(valorConcepto);
                                                                                                                    
                                                                                                                	lConceptos+=',"moneda_'+arrTipoCambios[pos][0]+'":"'+valorConcepto+'"'    
                                                                                                                }
                                                                                                                
                                                                                                                o='{"calculo":"'+fila.data.etiqueta+'","valor":"'+cv(fila.data.resultado,false,true)+'"'+lConceptos+'}';
                                                                                                                if(arrCalculos=='')
                                                                                                                	arrCalculos=o;
                                                                                                                else
                                                                                                                	arrCalculos+=','+o;
                                                                                                                
                                                                                                            }
                                                                                                            
                                                                                                            var posFila;
                                                                                                            var aTiposCambio='';
                                                                                                            for(pos=0;pos<arrTipoCambios.length;pos++)
                                                                                                            {
                                                                                                                tCambios='{"tipoMoneda":"'+arrTipoCambios[pos][0]+'","etiquetaDivisa":"'+arrTipoCambios[pos][1]+'","tipoCambio":"'+gEx('txtCambio_'+arrTipoCambios[pos][0]).getValue()+'"}';
                                                                                                                if(aTiposCambio=='')
                                                                                                                	aTiposCambio=tCambios;
                                                                                                                else
                                                                                                                	aTiposCambio+=','+tCambios;
                                                                                                                 
                                                                                                            }
                                                                                                            
                                                                                                            var cadObj='{"nombreConcepto":"'+cv(gE('nombrePerfil').value,false,true)+'","tipoReporte":"2","arrParametros":['+
                                                                                                            	arrParametros+'],"arrCalculos":['+arrCalculos+'],"arrTiposCambio":['+aTiposCambio+'],"fechaCambioDivisa":"'+gEx('dteFechaCambioDivisa').getValue().format('Y-m-d')+'"}';
                                                                                                        	
                                                                                                            var aParams=[['cadObj',bE(cadObj)]];
                                                                                                        	enviarFormularioDatosV('../reportes/liquidador/reporteCalculo.php',aParams,'POST');
                                                                                                        }
                                                                                                
                                                                                            }
                                                                                		]
                                                                                
                                                                            }
                                                                            
                                                                            
                                                                          ],
                                                                activeTab:1,
                                                                items:	[
                                                                			crearGridParametrosEntrada(),
                                                                            {
                                                                                title:'Resultado',
                                                                                id:'tabPanelResultado',
                                                                                layout:'border',
                                                                                items:	[
                                                                                			crearGridResultado()
                                                                                        ]
                                                                            }
                                                                		]
                                                            }
                                                            
                                                        ]
                                            }
                                         ]
                            }
                        )   
	
    
    
    new Ext.form.DateField	(
    							{
                                	id:'dteFechaCambioDivisa',
                                    renderTo:'divFechaCambioDivisa',
                                    value:fechaBaseCambioDivisa,
                                    width:130,
                                    maxValue:'<?php echo $fechaActual ?>',
                                    listeners:	{
                                    				select:function(dteCampo,newValue,oldValue)
                                                    		{
                                                            	obtenerValoresDivisaFechaCambio(newValue.format('Y-m-d'));
                                                            }
                                    			},
                                    ctCls:'campoFechaSIUGJ'
                                }
    						)
	gEx('panelGlobal').setActiveTab(0);                            
    gEx('panelGlobal').hideTabStripItem(1);  
    
    if(gE('idFormulario').value=='-1')
    {
    	gEx('panelGeneral').setTitle('Liquidador Judicial');
        
    }
    else
    {
    	var dsDatos=eval(bD(gE('arrResultados').value));
    	if(dsDatos.length>0)
        {
            gEx('panelGlobal').unhideTabStripItem(1);
            gEx('btnExportar').show();
        }
    }                      
}


function obtenerValoresDivisaFechaCambio(fechaReferencia)
{
	function funcAjax()
{
    var resp=peticion_http.responseText;
    arrResp=resp.split('|');
    if(arrResp[0]=='1')
    {
    	var x;
        var aDivisas=eval(arrResp[1]);
        
        for(x=0;x<aDivisas.length;x++)
        {
        	gEx('txtCambio_'+aDivisas[x].idDivisa).setValue(Ext.util.Format.usMoney(aDivisas[x].valorCambio));
        }
        actualizarMontos();
    }
    else
    {
        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
    }
}
obtenerDatosWeb('../paginasFunciones/funcionesLiquidador.php',funcAjax, 'POST','funcion=12&fechaBase='+fechaReferencia,true);
}


function aplicarCalculosConceptos(evitarCalculosConcepto)
{
	gEx('panelGlobal').hideTabStripItem(1); 
    gEx('panelGlobal').setActiveTab(0);
    var objParametros='"idFormulario":"'+gE('idFormulario').value+'","idRegistro":"'+gE('idRegistro').value+
                    '","idPerfil":"'+gE('idPerfil').value+'"';
                    
                    
                    
    var aTiposCambio='';
    for(pos=0;pos<arrTipoCambios.length;pos++)
    {
        tCambios='{"tipoMoneda":"'+arrTipoCambios[pos][0]+'","tipoCambio":"'+gEx('txtCambio_'+arrTipoCambios[pos][0]).getValue()+'"}';
        if(aTiposCambio=='')
            aTiposCambio=tCambios;
        else
            aTiposCambio+=','+tCambios;
         
    }   
    
    objParametros+=',"fechaCambioDivisa":"'+gEx('dteFechaCambioDivisa').getValue().format('Y-m-d')+'","cambiosDivisas":['+aTiposCambio+']' ;                                                                                                        
    var token='';
    var x;
    var fila;
    var gParametros=gEx('gParametros');
    for(x=0;x<gParametros.getStore().getCount();x++)
    {
        fila=gParametros.getStore().getAt(x);
        if(fila.data.valor=='')
        {
            function resp()
            {
                gParametros.startEditing(x,3);
            }
            msgBox('Debe ingresar el valor del par&aacute;metro: '+fila.data.etiqueta,resp);
            return;
        }
        
        token='"'+fila.data.nombreParametro+'":"'+cv(fila.data.tipoEntrada=='4'?fila.data.valor.format('Y-m-d'):fila.data.valor)+'"';
        if(objParametros=='')
            objParametros=token;
         else
            objParametros+=','+token;
    }   
    
    objParametros='{'+objParametros+'}';
    
    var gResultados=gEx('gResultados');
    gResultados.getStore().removeAll();
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var arrResultados=eval(arrResp[1]);
            var x;
            var r;
            var obj={};
            
            for(x=0;x<arrResultados.length;x++)
            {
                obj={
                        idCalculo:arrResultados[x].idCalculo,
                        etiqueta:arrResultados[x].etiqueta,
                        resultado:arrResultados[x].resultado,
                        formatoPresentacion:arrResultados[x].formatoPresentacion
                    }
                  
                
                for(pos=0;pos<arrTipoCambios.length;pos++)
                {
                
                	if(typeof(arrResultados[x]['moneda_'+arrTipoCambios[pos][0]])=='undefided')
                   	 	obj['moneda_'+arrTipoCambios[pos][0]]='---';
                   	else
                    	obj['moneda_'+arrTipoCambios[pos][0]]=arrResultados[x]['moneda_'+arrTipoCambios[pos][0]];
                }
                    
				           
                r=new regResultado	(
                                        obj
                                    );
                                  
                gResultados.getStore().add(r);
            }   
            gEx('panelGlobal').unhideTabStripItem(1);
            gEx('panelGlobal').setActiveTab(1);
            
            
      /*      if(!evitarCalculosConcepto)
	.           setTimeout(actualizarMontos, 500);*/


            gEx('btnExportar').show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesLiquidador.php',funcAjax, 'POST','funcion=11&cadObj='+objParametros,true);

}

function crearGridParametrosEntrada()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'nombreParametro'},
		                                                {name: 'etiqueta'},
		                                                {name:'valor'},
                                                        {name: 'tipoEntrada'},
                                                        {name: 'opciones'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesLiquidador.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'etiqueta', direction: 'ASC'},
                                                            groupField: 'etiqueta',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='10';
                                        proxy.baseParams.idPerfil=gE('idPerfil').value;
                                        proxy.baseParams.iF=gE('idFormulario').value;
                                        proxy.baseParams.iR=gE('idRegistro').value;
                                    }
                        )   


	alDatos.on('load',function(proxy)
    								{
                                    	var fila;
                                    	var x;
                                        var arrParametros=eval(bD(gE('arrParametros').value));
                                        var pos;
                                        
                                        for(x=0;x<gEx('gParametros').getStore().getCount();x++)
                                        {
                                        	
                                        	fila=gEx('gParametros').getStore().getAt(x);
                                        	pos=existeValorMatriz(arrParametros,fila.data.nombreParametro);   
                                            if(pos!=-1)
                                            { 
                                                valor=arrParametros[pos][1];
                                                
                                                fila.set('valor',valor);
											}
                                        }
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            
                                                            {
                                                                header:'Par&aacute;metro',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'etiqueta',
                                                                renderer:function(val)
                                                                		{
                                                                        	return '<b>'+val+':</b>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Tipo de Dato',
                                                                width:270,
                                                                sortable:true,
                                                                dataIndex:'tipoEntrada',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrTiposEntrada,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Valor',
                                                                width:270,
                                                                editor:	{xtype:'textfield'},
                                                                sortable:true,
                                                                dataIndex:'valor',
                                                                renderer:formatearValorParametro
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                            {
                                                                id:'gParametros',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                clicksToEdit:1,
                                                                cls:'gridSiugj',
                                                                cm: cModelo,
                                                                title:'Datos de Entrada',
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                
                                                                columnLines : true,                                                                
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
                            	var ctrl=null;

                                    switch(parseInt(e.record.data.tipoEntrada))
                                    {
                                        
                                        case 1:
                                            ctrl=new Ext.form.NumberField (
                                                                            {
                                                                                allowDecimals:false,
                                                                                cls:'controlSIUGJ'
                                                                            }
                                                                        )
                                        break;
                                        case 2:
                                            ctrl=new Ext.form.NumberField (
                                                                            {
                                                                                allowDecimals:true,
                                                                                cls:'controlSIUGJ'
                                                                            }
                                                                        )
                                        break;
                                        case 3:
                                            ctrl=new Ext.form.NumberField (
                                                                            {
                                                                                allowDecimals:true,
                                                                                cls:'controlSIUGJ'
                                                                            }
                                                                        )
                                        break;
                                        case 4:
                                            ctrl=new Ext.form.DateField ({ctCls:'campoFechaGrid'});
                                        break;
                                         case 5:
                                            ctrl=crearComboExt('cmbEditor',e.record.data.opciones,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
                                        break;
                                         case 6:
                                            ctrl=crearComboExt('cmbEditor',e.record.data.opciones,0,0,null,{multiSelect:true,transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
                                        break;
                                        
                                   
                                    }
                                    
                                    if(ctrl)
	                                	e.grid.getColumnModel().setEditor(3,ctrl);
                                    else
                                    	e.cancel=true;
                            }
    			)
        return 	tblGrid;
}

function formatearValorParametro(val,meta,registro)
{

    switch(parseInt(registro.data.tipoEntrada))
    {
        
        case 1:
            return Ext.util.Format.number(val,'0,000');
        break;
        case 2:
            return Ext.util.Format.number(val,'0,000.00');
        break;
        case 3:
            return Ext.util.Format.usMoney(val);
        break;
        case 4:
            if(val!='')
            {
            	if(!val.format)
                {
                	val=Date.parseDate(val,'Y-m-d');
                	registro.set('valor',val)
                }
                return val.format('d/m/Y');
            }

            return '';
        break;
        case 5:
        case 6:
            return formatearValorRenderer(registro.data.opciones,val);
        break;
        
    
    }

}

function divisaActualizada(ctr)
{
	var valor=Ext.util.Format.usMoney(normalizarValor(ctr.getValue()));
    if(valor=='$NaN.00')
    {
    	valor=Ext.util.Format.usMoney(0);
    }
	ctr.setValue(valor);
	actualizarMontos()
}

function actualizarMontos()
{
	
	var x;
    var pos;
    var fila;
    var gResultados=gEx('gResultados');
    
    
    if(idFormulario!=-1)
    {
    	
        aplicarCalculosConceptos(true);
        return;
    }
    
    for(x=0;x<gResultados.getStore().getCount();x++)
    {
        fila=gResultados.getStore().getAt(x);
        if(fila.data.formatoPresentacion=='3')
        {
        	
            for(pos=0;pos<arrTipoCambios.length;pos++)
            {
                var valorCambio=gEx('txtCambio_'+arrTipoCambios[pos][0]).getValue();
                if(valorCambio=='')
                    valorCambio=0;
				else
                	valorCambio=normalizarValor(valorCambio);
                var valorCambioConcepto=(parseFloat(valorCambio)==0?0:parseFloat(normalizarValor(fila.data.resultado))/parseFloat(valorCambio));
        		fila.set('moneda_'+arrTipoCambios[pos][0],valorCambioConcepto);
                fila.set('resultado',Ext.util.Format.usMoney(normalizarValor(fila.data.resultado)));
                
                
            }
        }  
        else
        {
        	for(pos=0;pos<arrTipoCambios.length;pos++)
            {
        		fila.set('moneda_'+arrTipoCambios[pos][0],'---');
            }
        } 
        
    }
    
    gResultados.getView().refresh();
}

function crearGridResultado()
{
	var dsDatos=eval(bD(gE('arrResultados').value));
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	arrResultado
                                                    }
                                                );

		

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer({width:40}),
														{
															header:'Concepto',
															width:300,
															sortable:true,
															dataIndex:'etiqueta',
                                                            renderer:function(val)
                                                                		{
                                                                        	return '<b>'+val+':</b>';
                                                                        }
														},
														{
															header:'Resultado',
															width:300,
															sortable:true,
															dataIndex:'resultado',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	meta.attr='style="text-align:right";'
                                                                    	return val;
                                                                        
                                                                        
                                                                    }
														}
                                                        <?php
															echo $arrColumnas
														?>
                                                        
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gResultados',
                                                            store:alDatos,
                                                            frame:false,
                                                            cm: cModelo,
                                                            cls:'gridSiugj',
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            region:'center',
                                                            tbar:	[
                                                            			
                                                            			{
                                                                        	xtype:'label',                                                                            
                                                                            html:'<div class="letraNombreTableroNegro">Cambio de divisas:</div>'
                                                                        },
                                                                        {
                                                                        	xtype:'tbspacer',
                                                                            width:15
                                                                        }
                                                                        <?php
																			echo $arrCamposDivisas
																		?>,
                                                                        {
                                                                        	xtype:'label',                                                                            
                                                                            html:'<div class="letraNombreTableroNegro">Cambio al d&iacute;a:</div>'
                                                                        },
                                                                        {
                                                                        	xtype:'tbspacer',
                                                                            width:15
                                                                        },
                                                                        {
                                                                        	xtype:'label',                                                                            
                                                                            html:'<div id="divFechaCambioDivisa" style="width:140px; background-color: #FFF !important;"></div>'
                                                                        }
                                                            		],
                                                            columnLines : true,
                                                        }
                                                    );
	

	


	return 	tblGrid;	
}
