<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$consulta="select idGrupoCampo,tipoCampo from 905_tiposCampoEntrada where idIdioma=".$_SESSION["leng"]." and campoEntrada=1 order by tipoCampo";
	$tEntrada=uEJ($con->obtenerFilasArreglo($consulta));
	$consulta="select idTipoDocumento,tipoDocumento from 906_tipoDocumentos";
	$tDocumentos=($con->obtenerFilasArreglo($consulta));
?>
var tDocumento=<?php echo $tDocumentos ?>;

function mostrarVentanaPreguntasAbiertas()
{
	var cmbOrigenFechaHora=crearComboExt('cmbOrigenFechaHora',[['1','Fecha/hora del servidor'],['2','Fecha/hora del equipo local']],130,65,200);
    cmbOrigenFechaHora.setValue('1');
	var tEntradas=<?php echo $tEntrada?>;
    var btnSiguiente=	new Ext.Button	( 
                                            {
                                                text: 'Finalizar',
                                                minWidth:80,
                                                handler:function()
                                                        {
                                                            var idElemento=Ext.getCmp('idCmbTipoElemento').getValue();
                                                            if(idElemento=='')
                                                            {
                                                                function resp()
                                                                {
                                                                    gE('idCmbTipoElemento').focus(false,10);
                                                                }
                                                                msgBox('Debe elegir un tipo de campo de entrada',resp);
                                                                return;
                                                            }
                                                            
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
                                                            
                                                            switch(idElemento)
                                                            {
                                                                case '5':
                                                                case '11': 	//Grupo Texto
                                                                    var txtLogitud=Ext.getCmp('txtLongitud');
                                                                    var txtAncho=Ext.getCmp('txtAncho');
                                                                    var longitud=txtLogitud.getValue();
                                                                    var ancho=txtAncho.getValue();
                                                                    if(longitud=='')
                                                                    {
                                                                        function resp()
                                                                        {
                                                                            txtLogitud.focus(false,10);
                                                                        }
                                                                        msgBox('El valor ingresado no es v&aacute;lido',resp);
                                                                        return;
                                                                    }
                                                                    if(ancho=='')
                                                                    {
                                                                        function resp()
                                                                        {
                                                                            txtAncho.focus(false,10);
                                                                        }
                                                                        msgBox('El valor ingresado no es v&aacute;lido',resp);
                                                                        return;
                                                                    }
                                                                
                                                                    objConfCampo='{"longitud":"'+longitud+'","ancho":"'+ancho+'"}'		  
                                                                break;
                                                                case '25':
                                                                	
                                                                	if(gEx('txtFormato').getValue()=='')
                                                                    {
                                                                    	function resp()
                                                                        {
                                                                        	gEx('txtFormato').focus();
                                                                        }
                                                                        msgBox('Debe ingresar el formato de fecha a presentar',resp);
                                                                        return;
                                                                    }
                                                                    
                                                                    var txtAnchoFecha=gEx('txtAnchoFecha');
                                                                    if(txtAnchoFecha.getValue()=='')
                                                                    	txtAnchoFecha.setValue(30);
                                                                	objConfCampo='{"formato":"'+gEx('txtFormato').getValue()+'","ancho":"'+txtAnchoFecha.getValue()+'","origenFecha":"'+cmbOrigenFechaHora.getValue()+'"}';		  

                                                                break;
                                                                default:
                                                                    objConfCampo=null
                                                            }
                                                            
                                                            var objFinal='{"idFormulario":"'+idFormulario+'","tipoElemento":"'+idElemento+'","confCampo":'+objConfCampo+',"nomCampo":"'+txtNombreCampo+'","posX":"@posX","posY":"@posY","obligatorio":"'+comboSiNo.getValue()+'","pregunta":null}';
                                                            h.objControl=objFinal;
                                                            gEx('ventanaPregAbiertas').close();
                                                            
                                                        }
                                            }
                                        );
                        
    var comboTipoE= crearComboExt('idCmbTipoElemento',tEntradas,140,5,330);
    var comboTipoDoc=crearComboExt('idCmbTipoDocumento',tDocumento,140,5);
    var comboSiNo=crearComboExt('idComboSiNo',arrSiNo,140,65,120);
    comboSiNo.setValue('0');
    function funcSelectTipoE(c,r,i)
    {
    	gEx('grupoTexto').hide();
        var x;
        var fila;
        for(x=0;x<c.getStore().getCount();x++)
        {
        	fila=c.getStore().getAt(x);
            if(gEx('fs_'+fila.data.id))
            {
            	gEx('fs_'+fila.data.id).hide();
            }
        }
        
        
        var id=r.get('id');
        var ancho;
        var alto;
        switch(id)
        {
            case '5':
            case '11': //Grupo Texto
                Ext.getCmp('grupoTexto').show();
                ventanaPregAbiertas.setHeight(320);
                
            break;
            default:
                if(gEx('fs_'+id))
                {
                	gEx('fs_'+id).show();
	            	ventanaPregAbiertas.setHeight(320);	
                }
                else
                	ventanaPregAbiertas.setHeight(190);
            break;
        }
        Ext.getCmp('txtNombreCampo').focus(false,10);
    }			
    comboTipoE.on('select',funcSelectTipoE);
                            
    var txtLongitud= new Ext.form.NumberField	({
                                                    id:'txtLongitud',
                                                    x:120,
                                                    y:5,
                                                    width:70,
                                                    hideLabel:true,
                                                    allowDecimals:false,
                                                    value:30
                                                });				
                                                        
    var txtAncho= new Ext.form.NumberField	({
                                                    id:'txtAncho',
                                                    x:120,
                                                    y:35,
                                                    width:70,
                                                    hideLabel:true,
                                                    allowDecimals:false,
                                                    value:30
                                                });	
    
    var txtNombreCampo=new Ext.form.TextField	(
    												{
                                                    	id:'txtNombreCampo',
                                                        x:140,
                                                        y:35,
                                                        width:160,
                                                        hideLabel:true,
                                                        maskRe:/^[a-zA-Z0-9]$/

                                                       
                                                    }
    											)
    
    var grupoTextoCorto=new Ext.form.FieldSet	(
                                                    {
                                                        id:'grupoTexto',
                                                        x:10,
                                                        y:105,
                                                        width:455,
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
                                                                                                html:'Longitud m&aacute;xima:'
                                                                                                
                                                                                            }
                                                                                        ),
                                                                    txtLongitud,
                                                                    new Ext.form.Label	(
                                                                                            {
                                                                                                x:5,
                                                                                                y:40,
                                                                                                width:200,
                                                                                                html:'Ancho del control:'
                                                                                                
                                                                                            }
                                                                                        ),
                                                                    txtAncho
                                                                   
                                                                ]
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
                                                                                        text:'Tipo de entrada:'
                                                                                    }
                                                                                ) ,
                                                            comboTipoE,
                                                            new Ext.form.Label	(
                                                                                    {
                                                                                        x:5,
                                                                                        y:40,
                                                                                        text:'ID Control:'
                                                                                    }
                                                                                ) ,
	                                                        txtNombreCampo,                        
                                                                                                                                                    
                                                            new Ext.form.Label	(
                                                                                    {
                                                                                        x:5,
                                                                                        y:70,
                                                                                        text:'¿Campo obligatorio?:'
                                                                                    }
                                                                                ) , 
                                                            comboSiNo,
                                                            grupoTextoCorto,
                                                            {
                                                            	id:'fs_25',
                                                            	xtype:'fieldset',
                                                                width:455,
                                                                height:125,
                                                                hidden:true,
		                                                        layout: 'absolute',
                                                                x:10,
                                                        		y:105,
        		                                                title:'Configuraci&oacute;n del control',
                                                                items:	[
                                                                			{
                                                                            	x:10,
                                                                                xtype:'label',
                                                                                y:10,
                                                                                html:'Formato de fecha:'
                                                                            },
                                                                            {
                                                                            	x:130,
                                                                                y:5,
                                                                                xtype:'textfield',
                                                                                width:200,
                                                                                id:'txtFormato'
                                                                            },
                                                                            {
                                                                                x:10,
                                                                                y:40,
                                                                                width:200,
                                                                                xtype:'label',
                                                                                html:'Ancho del control:'
                                                                                
                                                                            },
                                                                            {
                                                                            	x:130,
                                                                                y:35,
                                                                                width:70,
                                                                                xtype:'numberfield',
                                                                                allowDecimals:false,
                                                                                allowNegative:false,
                                                                                id:'txtAnchoFecha',
                                                                                value:30
                                                                            },
                                                                            {
                                                                                x:10,
                                                                                y:70,
                                                                                width:200,
                                                                                xtype:'label',
                                                                                html:'Origen fecha/hora:'
                                                                                
                                                                            },
                                                                            cmbOrigenFechaHora
                                                                		]
                                                            }
                                                            
                                                           
                                                        ]
                                            }
                                        );
    
    ventanaPregAbiertas = new Ext.Window	(
                                                {
                                                	id:'ventanaPregAbiertas',
                                                    title: 'Propiedades',
                                                    width: 500,
                                                    height:190,
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
                                                                                    txtLongitud.focus(true,10);
                                                                                }
                                                                            }
                                                                },
                                                    buttons:	[
                                                                    
                                                                    btnSiguiente,
                                                                    {
                                                                        text: 'Cancelar',
                                                                        minWidth:80,
                                                                        handler:function()
                                                                                {
                                                                                    ventanaPregAbiertas.close();
                                                                                }
                                                                    }
                                                                ]
                                                }
                                            );
	
	ventanaPregAbiertas.show();
    comboTipoE.focus(false,10);
}