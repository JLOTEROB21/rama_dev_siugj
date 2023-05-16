<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>	


function mostrarVentanaPreguntasUnicas(tipoElemento)
{
	idFormulario=gE('idFormulario').value;
    var arrFechaMin=[];
    var arrFechaMax=[];
    var txtTamMax= new Ext.form.NumberField	({
                                                    id:'txtTamMax',
                                                    x:140,
                                                    y:35,
                                                    width:70,
                                                    hideLabel:true,
                                                    allowDecimals:false,
                                                    value:200
                                                });	                                                    					
                                                
    var txtAnchoTL= new Ext.form.NumberField	({
                                                    id:'txtAnchoTL',
                                                    x:120,
                                                    y:5,
                                                    width:100,
                                                    hideLabel:true,
                                                    allowDecimals:false,
                                                    value:400
                                                });	
                                                
    var txtAltoTL= new Ext.form.NumberField	({
                                                    id:'txtAltoTL',
                                                    x:120,
                                                    y:35,
                                                    width:100,
                                                    hideLabel:true,
                                                    allowDecimals:false,
                                                    value:250
                                                });	                                                                                                        

    


	var tmeHoraMin=new Ext.form.TimeField	(
                                                {
                                                    id:'tmeHoraMin',
                                                    x:140,
                                                    y:5,
                                                    width:110,
                                                    hideLabel:true,
                                                    format:'H:i'
                                                }
                                            )
                                            
    var tmeHoraMax=new Ext.form.TimeField	(
                                                {
                                                    id:'tmeHoraMax',
                                                    x:140,
                                                    y:35,
                                                    width:110,
                                                    hideLabel:true,
                                                    format:'H:i'
                                                }
                                            )  

	var comboTipoDoc=crearComboExt('idCmbTipoDocumento',tDocumento,140,5);
    var comboSiNo=crearComboExt('idComboSiNo',arrSiNo,140,65,120);
    comboSiNo.setValue('0');
    
	comboSiNo.setPosition(140,35);

	var grupoArchivo=new Ext.form.FieldSet	(
                                                    {
                                                        id:'grupoArchivo',
                                                        x:10,
                                                        y:80,
                                                        width:375,
                                                        height:100,
                                                        hidden:true,
                                                        layout: 'absolute',
                                                        title:'Configuraci&oacute;n del control',
                                                        items:	[
                                                                    new Ext.form.Label	(
                                                                                            {
                                                                                                x:5,
                                                                                                y:10,
                                                                                                width:200,
                                                                                                html:'Extensiones v&aacute;lidas:'
                                                                                                
                                                                                            }
                                                                                        ),
                                                                    comboTipoDoc,
                                                                    new Ext.form.Label	(
                                                                                            {
                                                                                                x:5,
                                                                                                y:40,
                                                                                                width:200,
                                                                                                html:'Tama&ntilde;o m&aacute;ximo (kb):'
                                                                                                
                                                                                            }
                                                                                        ),
                                                                    txtTamMax
                                                                ]
                                                    }
                                                )
                                                
    var grupoHora=new Ext.form.FieldSet	(
                                                    {
                                                        id:'grupoHora',
                                                        x:10,
                                                        y:80,
                                                        width:400,
                                                        height:155,
                                                        hidden:true,
                                                        layout: 'absolute',
                                                        title:'Configuraci&oacute;n del control',
                                                        items:	[
                                                                    new Ext.form.Label	(
                                                                                            {
                                                                                                x:5,
                                                                                                y:10,
                                                                                                width:200,
                                                                                                html:'Hora m&iacute;nima:'
                                                                                                
                                                                                            }
                                                                                        ),
                                                                    tmeHoraMin,
                                                                    new Ext.form.Label	(
                                                                                            {
                                                                                                x:5,
                                                                                                y:40,
                                                                                                width:200,
                                                                                                html:'Hoa m&aacute;xima:'
                                                                                                
                                                                                            }
                                                                                        ),
                                                                    tmeHoraMax,
                                                                   
                                                                    {
                                                                    	xtype:'label',
                                                                        x:5,
                                                                        y:65,
                                                                        html:'Intervalo:'
                                                                    },
                                                                    {
                                                                    	id:'tmeIntervalo',
                                                                    	xtype:'numberfield',
                                                                        x:140,
                                                                        y:60,
                                                                        value:15,
                                                                        width:60
                                                                        
                                                                    },
                                                                    {
                                                                    	x:205,
                                                                        y:65,
                                                                    	xtype:'label',
                                                                        text:'Minutos'
                                                                    }
                                                                    ,
                                                                     new Ext.form.Label	(
                                                                                            {
                                                                                                x:5,
                                                                                                y:93,
                                                                                                html:'<font color="brown">Deje el campo vacio si no requiere validar hora m&iacute;nima, m&aacute;xima o ambas</font>'
                                                                                                
                                                                                            }
                                                                                        )
                                                                    

                                                                ]
                                                    }
                                                ) 
	
    var lblFechaMin='';
    var lblFechaMax='';
    if(tipoElemento==8)
    {
    	if(arrFechaMin.length==0)
        	lblFechaMin='Sin establecer';
        else
        	lblFechaMin=generarCadenaExpresionQuery(arrFechaMin,null);    
        if(arrFechaMax.length==0)
	        lblFechaMax='Sin establecer';
        else
        	lblFechaMax=generarCadenaExpresionQuery(arrFechaMax,null);    
    }
    
	var grupoFecha=new Ext.form.FieldSet	(
                                                    {
                                                        id:'grupoFecha',
                                                        x:10,
                                                        y:80,
                                                        width:385,
                                                        height:185,
                                                        hidden:true,
                                                        layout: 'absolute',
                                                        title:'Configuraci&oacute;n del control',
                                                        items:	[
                                                                    new Ext.form.Label	(
                                                                                            {
                                                                                                x:5,
                                                                                                y:10,
                                                                                                width:200,
                                                                                                html:'Fecha m&iacute;nima:'
                                                                                                
                                                                                            }
                                                                                        ),
                                                                    
                                                                    {
                                                                    	html:'<a href="javascript:modificarFecha(\''+bE('1')+'\')">'+lblFechaMin+'</a>',
                                                                        xtype:'label',
                                                                        x:100,
                                                                        y:10,
                                                                        id:'lblFecha1'
                                                                        
                                                                    },
                                                                    
                                                                    new Ext.form.Label	(
                                                                                            {
                                                                                                x:5,
                                                                                                y:40,
                                                                                                width:200,
                                                                                                html:'Fecha m&aacute;xima:'
                                                                                                
                                                                                            }
                                                                                        ),
                                                                    
                                                                    {
                                                                    	html:'<a href="javascript:modificarFecha(\''+bE('2')+'\')">'+lblFechaMax+'</a>',
                                                                        xtype:'label',
                                                                        x:100,
                                                                        y:40,
                                                                        id:'lblFecha2'
                                                                        
                                                                    },
                                                                     {
                                                                     	xtype:'label',
                                                                    	x:10,
                                                                        y:75,
                                                                        html:'Indique los d&iacute;s que desee marcar como <b>NO</b> elegibles:'
                                                                    },
                                                                    
                                                                    {
                                                                    	id:'checkDias',
                                                                    	x:10,
                                                                        y:100,
                                                                    	xtype:'checkboxgroup',
                                                                        columns:4,
                                                                        items:	[
                                                                        			{
                                                                                        xtype:'checkbox',
                                                                                        boxLabel:'Lunes',
                                                                                        value:'1',
                                                                                        name:'diasSel'
                                                                                    },
                                                                                    {
                                                                                        xtype:'checkbox',
                                                                                        boxLabel:'Martes',
                                                                                        value:'2',
                                                                                        name:'diasSel'
                                                                                    },
                                                                                    {
                                                                                        xtype:'checkbox',
                                                                                        boxLabel:'Mi&eacute;rcoles',
                                                                                        value:'3',
                                                                                        name:'diasSel'
                                                                                    },
                                                                                    {
                                                                                        xtype:'checkbox',
                                                                                        boxLabel:'Jueves',
                                                                                        value:'4',
                                                                                        name:'diasSel'
                                                                                    },
                                                                                    {
                                                                                        xtype:'checkbox',
                                                                                        boxLabel:'Viernes',
                                                                                        value:'5',
                                                                                        name:'diasSel'
                                                                                    },
                                                                                    {
                                                                                        xtype:'checkbox',
                                                                                        boxLabel:'S&aacute;bado',
                                                                                        value:'6',
                                                                                        name:'diasSel'
                                                                                    },
                                                                                    {
                                                                                        xtype:'checkbox',
                                                                                        boxLabel:'Domingo',
                                                                                        value:'0',
                                                                                        name:'diasSel'
                                                                                    }
                                                                        			
                                                                        		]
                                                                    }
                                                                    
                                                                    
                                                                    

                                                                ]
                                                    }
                                                ) 
                                                                                                   
                
    var grupoTextoLargo =new Ext.form.FieldSet	(
                                                    {
                                                        id:'grupoTextoLargo',
                                                        x:10,
                                                        y:80,
                                                        width:375,
                                                        height:100,
                                                        hidden:true,
                                                        layout: 'absolute',
                                                        title:'Configuraci&oacute;n del control',
                                                        items:	[
                                                                    new Ext.form.Label	(
                                                                                            {
                                                                                                x:5,
                                                                                                y:10,
                                                                                                width:200,
                                                                                                text:'Ancho:'
                                                                                                
                                                                                            }
                                                                                        ),
                                                                    txtAnchoTL,
                                                                    new Ext.form.Label	(
                                                                                            {
                                                                                                x:5,
                                                                                                y:40,
                                                                                                width:200,
                                                                                                text:'Alto:'
                                                                                                
                                                                                            }
                                                                                        ),
                                                                    txtAltoTL
                                                                    
                                                                ]
                                                    }
                                                )        

    var btnSiguiente=	new Ext.Button	( 
                                            {
                                                text: 'Finalizar',
                                                minWidth:80,
                                                handler:function()
                                                        {
                                                           
                                                            var txtNombreCampo=Ext.getCmp('txtNombreCampo').getValue();
                                                            if(txtNombreCampo=='')
                                                            {
                                                                function resp()
                                                                {
                                                                    Ext.getCmp('txtNombreCampo').focus(false,10);
                                                                }
                                                                msgBox('El valor ingresado no es v&aacute;lido',resp);
                                                                return;
                                                            }
                                                            
                                                            switch(tipoElemento)
                                                            {
                                                                case 12:	//Grupo Archivo
                                                                    var cmbTipoDoc=Ext.getCmp('idCmbTipoDocumento');
                                                                    var txtTamMax=Ext.getCmp('txtTamMax');
                                                                    var tipoDoc=cmbTipoDoc.getValue();
                                                                    var tamMax=txtTamMax.getValue();
                                                                
                                                                    if(tipoDoc=='')
                                                                    {
                                                                        function resp1()
                                                                        {
                                                                            cmbTipoDoc.focus(false,10);
                                                                        }
                                                                        msgBox('Debe elegir una opci&oacute;n',resp1);
                                                                        return;
                                                                    }
                                                                    if(tamMax=='')
                                                                    {
                                                                        function resp2()
                                                                        {
                                                                            txtTamMax.focus(false,10);
                                                                        }
                                                                        msgBox('El valor ingresado no es v&aacute;lido',resp2);
                                                                        return;
                                                                    }
                                                                
                                                                    objConfCampo='{"tipoDoc":"'+tipoDoc+'","tamMax":"'+tamMax+'"}'	
                                                                break;
                                                                case 8:	//Grupo Fecha
                                                                	var ventanaPregAbiertas=gEx('ventanaPregAbiertas');
                                                                    var fechaMin=generarCadenaExpresionTexto(ventanaPregAbiertas.objParam.fechaMin);
                                                                    var fechaMax=generarCadenaExpresionTexto(ventanaPregAbiertas.objParam.fechaMax);
                                                                    var diasSel=gEx('checkDias').getValues();
                                                                    
                                                                    objConfCampo='{"fechaMin":"'+bE(fechaMin)+'","fechaMax":"'+bE(fechaMax)+'","diasSel":"'+diasSel+'"}';		
                                                                    
                                                                break;                                                                    
                                                                case 9: //Grupo texto largo
                                                                case 10:
                                                                    var txtAltoTL=Ext.getCmp('txtAltoTL');
                                                                    var txtAnchoTL=Ext.getCmp('txtAnchoTL');
                                                                    var altoTL=txtAltoTL.getValue();
                                                                    var anchoTL=txtAnchoTL.getValue();
                                                                    if(anchoTL=='')
                                                                    {
                                                                        function resp4()
                                                                        {
                                                                            txtAnchoTL.focus(false,10);
                                                                        }
                                                                        msgBox('El valor ingresado no es v&aacute;lido',resp4);
                                                                        return;
                                                                    }
                                                                    if(altoTL=='')
                                                                    {
                                                                        function resp5()
                                                                        {
                                                                            altoTL.focus(false,10);
                                                                        }
                                                                        msgBox('El valor ingresado no es v&aacute;lido',resp5);
                                                                        return;
                                                                    }
                                                                    
                                                                
                                                                    objConfCampo='{"ancho":"'+anchoTL+'","alto":"'+altoTL+'"}'
                                                                
                                                                break;	
                                                                case 21:	//Grupo Fecha
                                                                    var tmeHoraMin=Ext.getCmp('tmeHoraMin');
                                                                    var tmeHoraMax=Ext.getCmp('tmeHoraMax');
                                                                    if(tmeHoraMin.getValue()!='')
                                                                    {
                                                                        
                                                                        var horaMin=tmeHoraMin.getValue();
                                                                    }
                                                                    else
                                                                        var horaMin=''; 
                                                                    if(tmeHoraMax.getValue()!='')
                                                                    {
                                                                       
                                                                        var horaMax=tmeHoraMax.getValue();
                                                                    }
                                                                    else
                                                                        var horaMax='';
                                                                        
                                                                    var tmeIntervalo=Ext.getCmp('tmeIntervalo');    
                                                                    if(tmeIntervalo.getValue()=='')
                                                                    {
                                                                        function resp6()
                                                                        {
                                                                            tmeIntervalo.focus(false,10);
                                                                        }
                                                                        msgBox('El valor ingresado no es v&aacute;lido',resp6);
                                                                        return;
                                                                    }
                                                                    else
	                                                                    intervalo=tmeIntervalo.getValue();
                                                                        
                                                                    objConfCampo='{"horaMin":"'+horaMin+'","horaMax":"'+horaMax+'","intervalo":"'+intervalo+'"}';	
                                                            	break;
                                                            }
                                                            
                                                            var objFinal='{"idFormulario":"'+idFormulario+'","tipoElemento":"'+tipoElemento+'","confCampo":'+objConfCampo+',"nomCampo":"'+txtNombreCampo+'","posX":"@posX","posY":"@posY","obligatorio":"'+comboSiNo.getValue()+'","pregunta":null}';
                                                           	
                                                            h.objControl=objFinal;
                                                            gEx('ventanaPregAbiertas').close();
                                                            
                                                        }
                                            }
                                        );
                        
    var txtNombreCampo=new Ext.form.TextField	(
    												{
                                                    	id:'txtNombreCampo',
                                                        x:140,
                                                        y:5,
                                                        width:160,
                                                        hideLabel:true,
                                                        maskRe:/^[a-zA-Z0-9]$/
                                                       
                                                    }
    											)
    
    var form = new Ext.form.FormPanel	(	
                                            {
                                                
                                                baseCls: 'x-plain',
                                                layout:'absolute',
                                                defaultType: 'numberfield',
                                                items: 	[
                                                            new Ext.form.Label	(
                                                                                    {
                                                                                        x:5,
                                                                                        y:10,
                                                                                        text:'ID Control:'
                                                                                    }
                                                                                ) ,
	                                                        txtNombreCampo,
                                                            new Ext.form.Label	(
                                                                                    {
                                                                                        x:5,
                                                                                        y:40,
                                                                                        text:'¿Campo obligatorio?:'
                                                                                    }
                                                                                ) , 
                                                            comboSiNo,
                                                            grupoArchivo,
                                                            grupoFecha,
                                                            grupoTextoLargo,
                                                            grupoHora
                                                        ]
                                            }
                                        );
    
    var tituloVentana;
    
    switch(tipoElemento)
    {
        case 12: //Grupo Archivo
            Ext.getCmp('grupoFecha').hide();
            Ext.getCmp('grupoTextoLargo').hide();
            Ext.getCmp('grupoArchivo').show();
            Ext.getCmp('grupoHora').hide();
            tituloVentana='Insertar campo de tipo archivo';
        break;
        case 8: //Grupo Fecha
            Ext.getCmp('grupoArchivo').hide();
            Ext.getCmp('grupoTextoLargo').hide();
            Ext.getCmp('grupoHora').hide();
            Ext.getCmp('grupoFecha').show();
            
            tituloVentana='Insertar campo de fecha';
        break;
        case 9: //Grupo texto largo
            ancho=400;
            alto=250;
            tituloVentana='Insertar campo texto enriquecido';
        case 10:
            if(tipoElemento==10)
            {
                ancho=600;
                alto=400;
                tituloVentana='Insertar campo texto largo';
            }
            Ext.getCmp('grupoArchivo').hide();
            Ext.getCmp('grupoFecha').hide();
            Ext.getCmp('grupoHora').hide();
            Ext.getCmp('txtAnchoTL').setValue(ancho);
            Ext.getCmp('txtAltoTL').setValue(alto);
            Ext.getCmp('grupoTextoLargo').show();
       	break;
        case 21:
            Ext.getCmp('grupoArchivo').hide();
            Ext.getCmp('grupoFecha').hide();
            //Ext.getCmp('txtAnchoTL').setValue(ancho);
            //Ext.getCmp('txtAltoTL').setValue(alto);
            Ext.getCmp('grupoTextoLargo').hide();
            Ext.getCmp('grupoHora').show();
                                             
        break;
    }
    
    ventanaPregAbiertas = new Ext.Window	(
                                                {
                                                	id:'ventanaPregAbiertas',
                                                    title: tituloVentana,
                                                    width: 440,
                                                    height:350,
                                                    minWidth: 280,
                                                    minHeight: 100,
                                                    layout: 'fit',
                                                    plain:true,
                                                    bodyStyle:'padding:5px;',
                                                    buttonAlign:'center',
                                                    items: form,
                                                    modal:true,
                                                    listeners : {
                                                                    show : {
                                                                                buffer : 10,
                                                                                fn : function() 
                                                                                {
                                                                                    //txtLongitud.focus(true,10);
                                                                                }
                                                                            }
                                                                },
                                                    buttons:	[
                                                                    
                                                                    btnSiguiente,
                                                                    {
                                                                        text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                                        minWidth:80,
                                                                        handler:function()
                                                                                {
                                                                                    ventanaPregAbiertas.close();
                                                                                }
                                                                    }
                                                                ]
                                                }
                                            );
	
    
    ventanaPregAbiertas.objParam={fechaMin:arrFechaMin,fechaMax:arrFechaMax};
	ventanaPregAbiertas.show();
    txtNombreCampo.focus(false,10);
}

function modificarFecha(tFecha)
{
	modificarFechaMinMax(tFecha,gEx('ventanaPregAbiertas'));
}

function modificarFechaMinMax(tFecha,ventanaOrigen)
{
	
	var titulo='Establecer fecha m&iacute;nima';
    if(bD(tFecha)=='2')
    {
    	titulo='Establecer fecha m&aacute;xima';
   }	
   var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			
														{
                                                        	layout:'absolute',
                                                        	xtype:'panel',
                                                            baseCls: 'x-plain',
                                                            x:0,
                                                            y:0,
                                                            width:460,
                                                            height:200,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Insertar fecha',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaFechaInsert();
                                                                                    }
                                                                            
                                                                        },
                                                                        
                                                                        {
                                                                        	icon:'../images/mas.gif',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Insertar valor',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaFechaInsertValor();
                                                                                    }
                                                                            
                                                                        },
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover elemento',
                                                                            handler:function()
                                                                            		{
                                                                                    	var vExpresion=gEx('vExpresion');
                                                                                    	if(vExpresion.arrFormulaFecha.length>0)
                                                                                        {
                                                                                            
                                                                                            vExpresion.arrFormulaFecha.splice(vExpresion.arrFormulaFecha.length-1,1);
                                                                                            generarCadenaExpresionQuery(vExpresion.arrFormulaFecha,'txtFormula');
                                                                                        }
                                                                                    }
                                                                            
                                                                        },
                                                                        {
                                                                        	width:32,
                                                                            text:'+',
                                                                            handler:function()
                                                                            		{
                                                                                    
                                                                                    	var vExpresion=gEx('vExpresion');
                                                                                    	var obj={
                                                                                        			tokenUsr: '+',
                                                                                                    tokenMysql:'+',
                                                                                                    tipoToken:0,
                                                                                                    tipoValor:''
                                                                                        		}
                                                                                    	vExpresion.arrFormulaFecha.push(obj);
                                                                                        generarCadenaExpresionQuery(vExpresion.arrFormulaFecha,'txtFormula');

                                                                                    }
                                                                        },
                                                                        {
                                                                        	width:32,
                                                                            text:'-',
                                                                            handler:function()
                                                                            		{
                                                                                    	var vExpresion=gEx('vExpresion');
                                                                                    	var obj={
                                                                                        			tokenUsr: '-',
                                                                                                    tokenMysql:'-',
                                                                                                    tipoToken:0,
                                                                                                    tipoValor:''
                                                                                        		}
                                                                                    	vExpresion.arrFormulaFecha.push(obj);
                                                                                        generarCadenaExpresionQuery(vExpresion.arrFormulaFecha,'txtFormula');
                                                                                    }
                                                                        },
                                                                        {
                                                                        	width:32,
                                                                            text:'(',
                                                                            handler:function()
                                                                            		{
                                                                                    	var vExpresion=gEx('vExpresion');
                                                                                    	var obj={
                                                                                        			tokenUsr: '(',
                                                                                                    tokenMysql:'(',
                                                                                                    tipoToken:0,
                                                                                                    tipoValor:''
                                                                                        		}
                                                                                    	vExpresion.arrFormulaFecha.push(obj);
                                                                                        generarCadenaExpresionQuery(vExpresion.arrFormulaFecha,'txtFormula');

                                                                                    }
                                                                        },
                                                                        {
                                                                        	width:32,
                                                                            text:')',
                                                                            handler:function()
                                                                            		{
                                                                                    	var vExpresion=gEx('vExpresion');
                                                                                    	var obj={
                                                                                        			tokenUsr: ')',
                                                                                                    tokenMysql:')',
                                                                                                    tipoToken:0,
                                                                                                    tipoValor:''
                                                                                        		}
                                                                                    	vExpresion.arrFormulaFecha.push(obj);
                                                                                        generarCadenaExpresionQuery(vExpresion.arrFormulaFecha,'txtFormula');

                                                                                    }
                                                                        }
                                                            		],
                                                            items:	[
                                                            			{
                                                                        	xtype:'textarea',
                                                                            x:10,
                                                                            y:10,
                                                                            width:460,
                                                                            height:100,
                                                                            id:'txtFormula'
                                                                        }
                                                            		]
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
                                    	id:'vExpresion',
										title: titulo,
										width: 480,
										height:220,
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
																		
                                                                        var cadObj=new Array();
                                                                        var x;
                                                                        var obj;
                                                                        var token;
                                                                        for(x=0;x<ventanaAM.arrFormulaFecha.length;x++)
                                                                        {
                                                                        	token=ventanaAM.arrFormulaFecha[x];
                                                                        	obj={tokenUsr:token.tokenUsr,tokenMysql:token.tokenMysql,tipoToken:token.tipoToken,tipoValor:token.tipoValor};
                                                                            cadObj.push(obj);
                                                                        	
                                                                        }
                                                                        if(bD(tFecha)=='1')
	                                                                        ventanaOrigen.objParam.fechaMin=cadObj;
                                                                        else
                                                                        	ventanaOrigen.objParam.fechaMax=cadObj;
                                                                        var cadena=generarCadenaExpresionQuery(ventanaAM.arrFormulaFecha,null);    
                                                                        if(cadena=='')
                                                                        	cadena='Sin establecer'
                                                                        cadena='<a href="javascript:modificarFecha(\''+tFecha+'\')">'+cadena+'</a>';
                                                                        gEx('lblFecha'+bD(tFecha)).setText(cadena,false);
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
	                                
	ventanaAM.arrFormulaFecha=ventanaOrigen.objParam.fechaMin;
    if(bD(tFecha)=='2')                              
    	ventanaAM.arrFormulaFecha=ventanaOrigen.objParam.fechaMax;
	generarCadenaExpresionQuery(ventanaAM.arrFormulaFecha,'txtFormula');        
	ventanaAM.show();		
}

function mostrarVentanaFechaInsert()
{

	var arrOrigen=[['1','Selecci\xF3n de fecha manual'],['4','Fecha del sistema']];//,['11','Fecha obtendida de un almac\xE9n de datos'],['7','Fecha obtenida de una consulta auxiliar']
    var comboOrigen=crearComboExt('comboOrigen',arrOrigen,160,5,260);
    
    comboOrigen.on('select',function(combo,registro)
    						{
                            	var vInsertFecha=gEx('vInsertFecha');
                                var tipoAlmacen;
                                switch(registro.get('id'))
                                {
                                	case '1':
                                    	vInsertFecha.setSize(500,170);
                                        gEx('panelSelFechaQuery').hide();
                                        gEx('panelSelFecha').show();
                                        gEx('fechaSel').setValue('');
                                    break;
                                    case '4':
                                    	vInsertFecha.setSize(500,120);
                                        gEx('panelSelFechaQuery').hide();
                                    	gEx('panelSelFecha').hide();
                                    break;
                                    case '7':
                                    case '11':
                                    	tipoAlmacen=1;
                                        if(registro.get('id')=='7')
                                        	tipoAlmacen=2;
                                    	vInsertFecha.setSize(500,210);
                                    	gEx('panelSelFecha').hide();
                                        gEx('panelSelFechaQuery').show();
                                        gEx('comboQueries').reset();
                                        gEx('comboCampos').reset();
                                        gEx('comboQueries').getStore().loadData(obtenerAlmacenesDatosDisponibles(tipoAlmacen));
                                        
                                    break;
                                    
                                }
                            }
    	
    				)
    var panelSelFecha=	{
    						id:'panelSelFecha',
    						xtype:'panel',
                            layout:'absolute',
                            baseCls: 'x-plain',
                            hidden:true,
                            x:0,
                            y:40,
                            height:100,
                            items:	[
                            			{
                                        	x:'10',
                                            y:'10',
                                            xtype:'label',
                                            html:'Seleccione fecha:'
                                            
                                        },
                                       	{
                                        	id:'fechaSel',
                                        	xtype:'datefield',
                                            x:160,
                                            y:5
	                                            
                                        }	
                            		]
    					}
    
    var arrQueries=[];
    var comboQueries=crearComboExt('comboQueries',arrQueries,160,5,280);
    comboQueries.on('select',function(combo,registro)
    						{
                            	var id=registro.get('id');
                                gEx('comboCampos').getStore().loadData(obtenerCamposDisponibles(id));
                                
                            }
    				)
    var comboCampos=crearComboExt('comboCampos',[],160,35,280);
    
    var panelSelFechaQuery=	{
                                id:'panelSelFechaQuery',
                                xtype:'panel',
                                layout:'absolute',
                                baseCls: 'x-plain',
                                hidden:true,
                                x:0,
                                y:40,
                                height:150,
                                items:	[
                                            {
                                                x:'10',
                                                y:'10',
                                                xtype:'label',
                                                html:'Seleccione almac\xE9n de datos:'
                                                
                                            },
                                            comboQueries,
                                            {
                                                x:'10',
                                                y:'40',
                                                xtype:'label',
                                                html:'Seleccione campo:'
                                                
                                            },
                                            comboCampos
                                        ]
                            }
    
	var form = new Ext.form.FormPanel(	
										{
                                        	
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	html:'Origen de la fecha a insertar:',
                                                            x:10,
                                                            y:10
                                                        },
                                                        comboOrigen,
                                                        panelSelFecha,
                                                        panelSelFechaQuery

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
                                    	id:'vInsertFecha',
										title: 'Insertar fecha',
										width: 500,
										height:120,
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
                                                                	ventanaAM.setSize(500,120);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
                                                                    	if(comboOrigen.getValue()=='')
                                                                        {
                                                                        	function funcResp()
                                                                            {
                                                                            	comboOrigen.focus();
                                                                            }
                                                                        	msgBox('Debe seleccionar el origen del cual se insertar&aacute; la fecha',funcResp);
                                                                        	return;
                                                                        }
                                                                        
																		switch(comboOrigen.getValue())
                                                                        {
                                                                        	case '1':
                                                                            	var fechaSel=gEx('fechaSel');
                                                                            	if(fechaSel.getValue()=='')
                                                                                {
                                                                                	function funcResp1()
                                                                                    {
                                                                                    	fechaSel.focus();	
                                                                                    }
                                                                                    msgBox('Debe seleccionar la fecha a insertar',funcResp1);
                                                                                    return;
                                                                                }
                                                                               
                                                                                var obj={
                                                                                            tokenUsr: "'"+fechaSel.getValue().format('d/m/Y')+"'",
                                                                                            tokenMysql:fechaSel.getValue().format('Y-m-d'),
                                                                                            tipoToken:1,
                                                                                            tipoValor:'date'
                                                                                        }
                                                                                var vExpresion=gEx('vExpresion');
                                                                                vExpresion.arrFormulaFecha.push(obj);
                                                                                generarCadenaExpresionQuery(vExpresion.arrFormulaFecha,'txtFormula');
                                                                                ventanaAM.close();
                                                                            break;
                                                                            case '4':
                                                                            	var obj={
                                                                                            tokenUsr: "[Fecha Sistema]",
                                                                                            tokenMysql:'8',
                                                                                            tipoToken:4,
                                                                                            tipoValor:'date'
                                                                                        }
                                                                                var vExpresion=gEx('vExpresion');
                                                                                vExpresion.arrFormulaFecha.push(obj);
                                                                                generarCadenaExpresionQuery(vExpresion.arrFormulaFecha,'txtFormula');
                                                                                ventanaAM.close();
                                                                            break;
                                                                            case '7':
                                                                            	if(comboQueries.getValue()=='')
                                                                                {
                                                                                	function resp5()
                                                                                    {
                                                                                    	comboQueries.focus();
                                                                                    }
                                                                                    msgBox('Debe seleccionar la consulta auxiliar de la cual se insertar&aacute; la fecha',resp5);
                                                                                    return;
                                                                                }
                                                                                
                                                                                if(comboCampos.getValue()=='')
                                                                                {
                                                                                	function resp6()
                                                                                    {
                                                                                    	comboCampos.focus();
                                                                                    }
                                                                                    msgBox('Debe seleccionar el campo del cual se tomar&aacute; la fecha',resp6);
                                                                                    return;
                                                                                }
                                                                            	var obj={
                                                                                            tokenUsr: "{Consulta:"+comboQueries.getRawValue()+" [Campo: "+comboCampos.getRawValue()+"]}",
                                                                                            tokenMysql:'',
                                                                                            tipoToken:7,
                                                                                            tipoValor:'date'
                                                                                        }
                                                                                var vExpresion=gEx('vExpresion');
                                                                                vExpresion.arrFormulaFecha.push(obj);
                                                                                generarCadenaExpresionQuery(vExpresion.arrFormulaFecha,'txtFormula');
                                                                                ventanaAM.close();
                                                                            
                                                                            break;
                                                                            case '11':
                                                                            	if(comboQueries.getValue()=='')
                                                                                {
                                                                                	function resp5()
                                                                                    {
                                                                                    	comboQueries.focus();
                                                                                    }
                                                                                    msgBox('Debe seleccionar el almac&eacute;n de datos del cual se insertar&aacute; la fecha',resp5);
                                                                                    return;
                                                                                }
                                                                                
                                                                                if(comboCampos.getValue()=='')
                                                                                {
                                                                                	function resp6()
                                                                                    {
                                                                                    	comboCampos.focus();
                                                                                    }
                                                                                    msgBox('Debe seleccionar el campo del cual se tomar&aacute; la fecha',resp6);
                                                                                    return;
                                                                                }
                                                                            	var obj={
                                                                                            tokenUsr: "{Consulta:"+comboQueries.getRawValue()+" [Campo: "+comboCampos.getRawValue()+"]}",
                                                                                            tokenMysql:'',
                                                                                            tipoToken:11,
                                                                                            tipoValor:'date'
                                                                                        }
                                                                                var vExpresion=gEx('vExpresion');
                                                                                vExpresion.arrFormulaFecha.push(obj);
                                                                                generarCadenaExpresionQuery(vExpresion.arrFormulaFecha,'txtFormula');
                                                                                ventanaAM.close();
                                                                            break;
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

}

function mostrarVentanaFechaInsertValor()
{
	var arrUnidadMedida=[['0','Valor de fecha'],['1','D\xEDas'],['2','Semanas'],['3','Meses'],['4','A\xF1os']];
	var arrOrigen=[['1','Valor constante'],['11','Valor obtenido de un almac\xE9n de datos'],['7','Valor obtenido de una consulta auxiliar']];
    var comboOrigen=crearComboExt('comboOrigen',arrOrigen,160,5,260);
    var comboUnidadMedidaF=crearComboExt('comboUnidadMedidaF',arrUnidadMedida,160,35,200);
    var comboUnidadMedidaQ=crearComboExt('comboUnidadMedidaQ',arrUnidadMedida,160,65,200);
    comboOrigen.on('select',function(combo,registro)
    						{
                            	var vInsertFecha=gEx('vInsertFecha');
                                var tipoAlmacen;
                                switch(registro.get('id'))
                                {
                                	case '1':
                                    	vInsertFecha.setSize(500,185);
                                        gEx('panelSelFechaQuery').hide();
                                        gEx('panelSelValor').show();
                                        gEx('txtValor').setValue('');
                                        gEx('txtValor').focus();
                                    break;
                                    case '7':
                                    case '11':
                                    	tipoAlmacen=1;
                                        if(registro.get('id')=='4')
                                        	tipoAlmacen=2;
                                    	vInsertFecha.setSize(500,210);
                                    	gEx('panelSelValor').hide();
                                        gEx('panelSelFechaQuery').show();
                                        gEx('comboQueries').reset();
                                        gEx('comboCampos').reset();
                                        gEx('comboQueries').getStore().loadData(obtenerAlmacenesDatosDisponibles(tipoAlmacen));
                                    break;
                                }
                            }
    	
    				)
    var panelSelValor=	{
    						id:'panelSelValor',
    						xtype:'panel',
                            layout:'absolute',
                            baseCls: 'x-plain',
                            hidden:true,
                            x:0,
                            y:40,
                            height:100,
                            items:	[
                            			{
                                        	x:'10',
                                            y:'10',
                                            xtype:'label',
                                            html:'Ingrese valor:'
                                            
                                        },
                                       	{
                                        	id:'txtValor',
                                        	xtype:'numberfield',
                                            x:160,
                                            y:5,
                                            allowDecimals:false,
                                            width:40
                                        },
                                        {
                                        	x:'10',
                                            y:'40',
                                            xtype:'label',
                                            html:'Considerar el valor en:'
                                        },
                                        comboUnidadMedidaF	
                            		]
    					}
    
    var arrQueries=[];
    var comboQueries=crearComboExt('comboQueries',arrQueries,160,5,280);
    comboQueries.on('select',function(combo,registro)
    						{
                            	var id=registro.get('id');
                                gEx('comboCampos').getStore().loadData(obtenerCamposDisponibles(id));
                                
                            }
    				)
    var comboCampos=crearComboExt('comboCampos',[],160,35,280);
    
    var panelSelFechaQuery=	{
                                id:'panelSelFechaQuery',
                                xtype:'panel',
                                layout:'absolute',
                                baseCls: 'x-plain',
                                hidden:true,
                                x:0,
                                y:40,
                                height:150,
                                items:	[
                                            {
                                                x:'10',
                                                y:'10',
                                                xtype:'label',
                                                html:'Seleccione almac\xE9n de datos:'
                                                
                                            },
                                            comboQueries,
                                            {
                                                x:'10',
                                                y:'40',
                                                xtype:'label',
                                                html:'Seleccione campo:'
                                                
                                            },
                                            comboCampos,
                                            {
                                                x:'10',
                                                y:'70',
                                                xtype:'label',
                                                html:'Considerar el valor en:'
                                            },
                                            comboUnidadMedidaQ
                                        ]
                            }
    
	var form = new Ext.form.FormPanel(	
										{
                                        	
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	html:'Origen del valor a insertar:',
                                                            x:10,
                                                            y:10
                                                        },
                                                        comboOrigen,
                                                        panelSelValor,
                                                        panelSelFechaQuery

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
                                    	id:'vInsertFecha',
										title: 'Insertar valor',
										width: 500,
										height:135,
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
                                                                	ventanaAM.setSize(500,120);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		if(comboOrigen.getValue()=='')
                                                                        {
                                                                        	function funcResp()
                                                                            {
                                                                            	comboOrigen.focus();
                                                                            }
                                                                        	msgBox('Debe seleccionar el origen del cual se insertar&aacute; el valor',funcResp);
                                                                        	return;
                                                                        }
                                                                        var tValor='day';

                                                                        if(comboUnidadMedidaQ.getValue()=='0')
                                                                        	tValor='date';
																		switch(comboOrigen.getValue())
                                                                        {
                                                                        	case '1':
                                                                            	var txtValor=gEx('txtValor');
                                                                            	if(txtValor.getValue()=='')
                                                                                {
                                                                                	function funcResp1()
                                                                                    {
                                                                                    	txtValor.focus();	
                                                                                    }
                                                                                    msgBox('Debe ingresar el valor a insertar',funcResp1);
                                                                                    return;
                                                                                }
                                                                                
                                                                                if(comboUnidadMedidaF.getValue()=='')
                                                                                {
                                                                                	function funcResp2()
                                                                                    {
                                                                                    	comboUnidadMedidaF.focus();	
                                                                                    }
                                                                                    msgBox('Debe ingresar la unidad de medida bajo la cual se considerar&aacute; el valor',funcResp2);
                                                                                    return;
                                                                                }
                                                                               
                                                                                var obj={
                                                                                            tokenUsr: "'"+txtValor.getValue()+' '+comboUnidadMedidaF.getRawValue()+"'",
                                                                                            tokenMysql:txtValor.getValue()+'|'+comboUnidadMedidaF.getValue(),
                                                                                            tipoToken:1,
                                                                                            tipoValor:tValor
                                                                                        }
                                                                                var vExpresion=gEx('vExpresion');
                                                                                vExpresion.arrFormulaFecha.push(obj);
                                                                                generarCadenaExpresionQuery(vExpresion.arrFormulaFecha,'txtFormula');
                                                                                ventanaAM.close();
                                                                            break;
                                                                            case '7':
                                                                            	if(comboQueries.getValue()=='')
                                                                                {
                                                                                	function resp5()
                                                                                    {
                                                                                    	comboQueries.focus();
                                                                                    }
                                                                                    msgBox('Debe seleccionar la consulta auxiliar de la cual se insertar&aacute; el valor',resp5);
                                                                                    return;
                                                                                }
                                                                                
                                                                                if(comboCampos.getValue()=='')
                                                                                {
                                                                                	function resp6()
                                                                                    {
                                                                                    	comboCampos.focus();
                                                                                    }
                                                                                    msgBox('Debe seleccionar el campo del cual se tomar&aacute; el valor',resp6);
                                                                                    return;
                                                                                }
                                                                                
                                                                                 if(comboUnidadMedidaQ.getValue()=='')
                                                                                {
                                                                                	function funcResp2()
                                                                                    {
                                                                                    	comboUnidadMedidaQ.focus();	
                                                                                    }
                                                                                    msgBox('Debe ingresar la unidad de medida bajo la cual se considerar&aacute; el valor',funcResp2);
                                                                                    return;
                                                                                }
                                                                                var campo=comboCampos.getValue();
                                                                                campo=buscarNodoID(gEx('arbolDataSet').getRootNode(),campo).nCampo;
                                                                            	var obj={
                                                                                            tokenUsr: "{Consulta:"+comboQueries.getRawValue()+" [Campo: "+comboCampos.getRawValue()+"], Unidad: "+comboUnidadMedidaQ.getRawValue()+"}",
                                                                                            tokenMysql:comboQueries.getValue()+'|'+campo+'|'+comboUnidadMedidaQ.getValue(),
                                                                                            tipoToken:7,
                                                                                            tipoValor:tValor
                                                                                        }
                                                                                var vExpresion=gEx('vExpresion');
                                                                                vExpresion.arrFormulaFecha.push(obj);
                                                                                generarCadenaExpresionQuery(vExpresion.arrFormulaFecha,'txtFormula');
                                                                                ventanaAM.close();
                                                                            
                                                                            break;
                                                                            case '11':
                                                                            	if(comboQueries.getValue()=='')
                                                                                {
                                                                                	function resp5()
                                                                                    {
                                                                                    	comboQueries.focus();
                                                                                    }
                                                                                    msgBox('Debe seleccionar el almac&eacute;n de datos del cual se insertar&aacute; el valor',resp5);
                                                                                    return;
                                                                                }
                                                                                
                                                                                if(comboCampos.getValue()=='')
                                                                                {
                                                                                	function resp6()
                                                                                    {
                                                                                    	comboCampos.focus();
                                                                                    }
                                                                                    msgBox('Debe seleccionar el campo del cual se tomar&aacute; el valor',resp6);
                                                                                    return;
                                                                                }
                                                                                
                                                                                if(comboUnidadMedidaQ.getValue()=='')
                                                                                {
                                                                                	function funcResp2()
                                                                                    {
                                                                                    	comboUnidadMedidaQ.focus();	
                                                                                    }
                                                                                    msgBox('Debe ingresar la unidad de medida bajo la cual se considerar&aacute; el valor',funcResp2);
                                                                                    return;
                                                                                }
                                                                                var campo=comboCampos.getValue();
                                                                                campo=buscarNodoID(gEx('arbolDataSet').getRootNode(),campo).nCampo;
                                                                            	var obj={
                                                                                            tokenUsr: "{Consulta:"+comboQueries.getRawValue()+" [Campo: "+comboCampos.getRawValue()+"], Unidad: "+comboUnidadMedidaQ.getRawValue()+"}",
                                                                                            tokenMysql:comboQueries.getValue()+'|'+campo+'|'+comboUnidadMedidaQ.getValue(),
                                                                                            tipoToken:11,
                                                                                            tipoValor:tValor
                                                                                        }
                                                                                var vExpresion=gEx('vExpresion');
                                                                                vExpresion.arrFormulaFecha.push(obj);
                                                                                generarCadenaExpresionQuery(vExpresion.arrFormulaFecha,'txtFormula');
                                                                                ventanaAM.close();
                                                                            break;
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

}

function mostrarVentanaConfiguracionFecha()
{
	var ctrlInterno=h.gE(idDivSel).getAttribute('controlInterno').split('_');
	var control=h.gE('_'+ctrlInterno[1]);
	var arrFechaMin=[];
    if(bD(control.getAttribute('fechaMin'))!='')
	    arrFechaMin=eval(bD(control.getAttribute('fechaMin')));
    var arrFechaMax=[];
    if(bD(control.getAttribute('fechaMax'))!='')
	    arrFechaMax=eval(bD(control.getAttribute('fechaMax')));
    var diasSel=eval('['+bD(control.getAttribute('diasSel'))+']');
    var lblFechaMin='';
    var lblFechaMax='';
    if(arrFechaMin.length==0)
        lblFechaMin='Sin establecer';
    else
        lblFechaMin=generarCadenaExpresionQuery(arrFechaMin,null);
    if(arrFechaMax.length==0)
        lblFechaMax='Sin establecer';
    else
        lblFechaMax=generarCadenaExpresionQuery(arrFechaMax,null);    
    var grupoFecha=new Ext.form.FieldSet	(
                                                    {
                                                        id:'grupoFecha',
                                                        x:10,
                                                        y:10,
                                                        width:385,
                                                        height:185,
                                                        layout: 'absolute',
                                                        title:'Configuraci&oacute;n del control',
                                                        items:	[
                                                                    new Ext.form.Label	(
                                                                                            {
                                                                                                x:5,
                                                                                                y:10,
                                                                                                width:200,
                                                                                                html:'Fecha m&iacute;nima:'
                                                                                                
                                                                                            }
                                                                                        ),
                                                                    
                                                                    {
                                                                    	html:'<a href="javascript:modificarFecha(\''+bE('1')+'\')">'+lblFechaMin+'</a>',
                                                                        xtype:'label',
                                                                        x:100,
                                                                        y:10,
                                                                        id:'lblFecha1'
                                                                        
                                                                    },
                                                                    
                                                                    new Ext.form.Label	(
                                                                                            {
                                                                                                x:5,
                                                                                                y:40,
                                                                                                width:200,
                                                                                                html:'Fecha m&aacute;xima:'
                                                                                                
                                                                                            }
                                                                                        ),
                                                                    
                                                                    {
                                                                    	html:'<a href="javascript:modificarFecha(\''+bE('2')+'\')">'+lblFechaMax+'</a>',
                                                                        xtype:'label',
                                                                        x:100,
                                                                        y:40,
                                                                        id:'lblFecha2'
                                                                        
                                                                    },
                                                                    {
                                                                    	x:10,
                                                                        y:75,
                                                                        xtype:'label',
                                                                        html:'Indique los d&iacute;s que desee marcar como <b>NO</b> elegibles:'
                                                                    },
                                                                    
                                                                    
                                                                    {
                                                                    	id:'checkDias',
                                                                    	x:10,
                                                                        y:100,
                                                                        columns:4,
                                                                    	xtype:'checkboxgroup',
                                                                       
                                                                        items:	[
                                                                        			{
                                                                                        xtype:'checkbox',
                                                                                        boxLabel:'Lunes',
                                                                                        value:'1',
                                                                                        name:'diasSel'
                                                                                    },
                                                                                    {
                                                                                        xtype:'checkbox',
                                                                                        boxLabel:'Martes',
                                                                                        value:'2',
                                                                                        name:'diasSel'
                                                                                    },
                                                                                    {
                                                                                        xtype:'checkbox',
                                                                                        boxLabel:'Mi&eacute;rcoles',
                                                                                        value:'3',
                                                                                        name:'diasSel'
                                                                                    },
                                                                                    {
                                                                                        xtype:'checkbox',
                                                                                        boxLabel:'Jueves',
                                                                                        value:'4',
                                                                                        name:'diasSel'
                                                                                    },
                                                                                    {
                                                                                        xtype:'checkbox',
                                                                                        boxLabel:'Viernes',
                                                                                        value:'5',
                                                                                        name:'diasSel'
                                                                                    },
                                                                                    {
                                                                                        xtype:'checkbox',
                                                                                        boxLabel:'S&aacute;bado',
                                                                                        value:'6',
                                                                                        name:'diasSel'
                                                                                    },
                                                                                    {
                                                                                        xtype:'checkbox',
                                                                                        boxLabel:'Domingo',
                                                                                        value:'0',
                                                                                        name:'diasSel'
                                                                                    }
                                                                        			
                                                                        		]
                                                                    }
                                                                ]
                                                    }
                                                ) 
                                                
    var form = new Ext.form.FormPanel	(	
                                            {
                                                
                                                baseCls: 'x-plain',
                                                layout:'absolute',
                                                defaultType: 'numberfield',
                                                items: 	[
                                                            
                                                            grupoFecha
                                                            
                                                        ]
                                            }
                                        );
                                                
	ventanaPregAbiertas = new Ext.Window	(
                                                {
                                                	id:'ventanaPregAbiertas',
                                                    title: 'Modificar configuraci&oacute;n de campo fecha',
                                                    width: 440,
                                                    height:300,
                                                    minWidth: 280,
                                                    minHeight: 100,
                                                    layout: 'fit',
                                                    plain:true,
                                                    bodyStyle:'padding:5px;',
                                                    buttonAlign:'center',
                                                    items: form,
                                                    modal:true,
                                                    listeners : {
                                                                    show : {
                                                                                buffer : 10,
                                                                                fn : function() 
                                                                                {
                                                                                    //txtLongitud.focus(true,10);
                                                                                }
                                                                            }
                                                                },
                                                    buttons:	[
                                                                    
                                                                    {
                                                                    	text:'Aceptar',
                                                                        handler:function()
                                                                        		{
                                                                                	var ventanaPregAbiertas=gEx('ventanaPregAbiertas');
                                                                                    var fechaMin=generarCadenaExpresionTexto(ventanaPregAbiertas.objParam.fechaMin);
                                                                                    var fechaMax=generarCadenaExpresionTexto(ventanaPregAbiertas.objParam.fechaMax);
                                                                                    var diasSel=gEx('checkDias').getValues();
                                                                                    objConfCampo='{"idElemento":"'+idElementoSel+'","fechaMin":"'+bE(fechaMin)+'","fechaMax":"'+bE(fechaMax)+'","diasSel":"'+diasSel+'"}';		
                                                                                    function funcAjax()
                                                                                    {
                                                                                        var resp=peticion_http.responseText;
                                                                                        arrResp=resp.split('|');
                                                                                        if(arrResp[0]=='1')
                                                                                        {
                                                                                        	control.setAttribute('fechaMin',bE(fechaMin));
                                                                                        	control.setAttribute('fechaMax',bE(fechaMax));
                                                                                            control.setAttribute('diasSel',bE(diasSel));
                                                                                        	ventanaPregAbiertas.close();
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                        }
                                                                                    }
                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=65&cadObj='+objConfCampo,true);

                                                                                    
                                                                                }
                                                                    },
                                                                    {
                                                                        text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                                        minWidth:80,
                                                                        handler:function()
                                                                                {
                                                                                    ventanaPregAbiertas.close();
                                                                                }
                                                                    }
                                                                ]
                                                }
                                            );
	
    
    ventanaPregAbiertas.objParam={fechaMin:arrFechaMin,fechaMax:arrFechaMax};
	ventanaPregAbiertas.show();
    gEx('checkDias').setValues(diasSel);
                                                
}