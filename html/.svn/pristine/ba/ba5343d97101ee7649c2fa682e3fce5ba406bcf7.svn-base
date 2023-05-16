<?php session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>	

function mostrarVentanaCampoOperacion(idControl)
{
    
    var soloLectura=false;
    var valor='';
    var accion='-1';
    if(idControl!=undefined)
    {
        soloLectura=true;
        valor=idControl;
        accion=h.idControlSel;
    }
    
    h.arrConsulta=new Array();
    var form = new Ext.form.FormPanel(	
                                        {
                                            baseCls: 'x-plain',
                                            layout:'absolute',
                                            defaultType: 'textfield',
                                            items: 	[
                                                        {
                                                            x:10,
                                                            y:15,
                                                            xtype:'label',
                                                            html:'ID Control:'
                                                        },
                                                        {
                                                            id:'txtNombreCampo',
                                                            x:80,
                                                            y:10,
                                                            width:130,
                                                            hideLabel:true,
                                                            maskRe:/^[a-zA-Z0-9]$/,
                                                            disabled:soloLectura,
                                                            value:valor
                                                        }
                                                        ,
                                                        {
                                                            xtype:'panel',
                                                            x:10,
                                                            y:60,
                                                            tbar: 	[
                                                                                {
                                                                                  text:'Agregar valor',
                                                                                  icon:'../images/mas.gif',
                                                                                  cls:'x-btn-text-icon',
                                                                                  menu:	[
                                                                                              {
                                                                                              
                                                                                                  text:'Ingresado por m&iacute;',
                                                                                                  handler:function()
                                                                                                          {
                                                                                                              mostrarVentanaValor();
                                                                                                          }
                                                                                              },
                                                                                              /*{
                                                                                                  text:'Generado de una consulta',
                                                                                                  handler:	function()	
                                                                                                            {
                                                                                                                mostrarVentanaGenerarConsulta();
                                                                                                            }
                                                                                              },*/
                                                                                              {
                                                                                                  text:'De control de formulario',
                                                                                                  handler:function()	
                                                                                                            {
                                                                                                                mostrarVentanaControlFormulario();
                                                                                                            }
                                                                                                  
                                                                                              },
                                                                                              {
                                                                                                  text:'De para&aacute;metro de formulario',
                                                                                                  handler:function()	
                                                                                                            {
                                                                                                                mostrarVentanaParametroFormulario();
                                                                                                            }
                                                                                                  
                                                                                              }
                                                                                              
                                                                                          ]
                                                                               },
                                                                                '-'
                                                                                ,
                                                                                
                                                                               {
                                                                                   xtype:'button',
                                                                                   text:'Remover',
                                                                                   icon:'../images/menos.gif',
                                                                                   cls:'x-btn-text-icon',
                                                                                   handler:function()
                                                                                          {
                                                                                              if(h.arrConsulta.length>0)
                                                                                              {
                                                                                                  h.arrConsulta.splice(h.arrConsulta.length-1,1);
                                                                                                  generarSentenciaConsultaOperacion();
                                                                                              }
                                                                                          }
                                                                               },
                                                                               '-'
                                                                               ,
                                                                                {
                                                                                     xtype:'button',
                                                                                     text:'(',
                                                                                     handler:function()
                                                                                            {
                                                                                                var arrValor=new Array();
                                                                                                arrValor[0]='(';
                                                                                                arrValor[1]='(';
                                                                                                arrValor[2]=1;
                                                                                                
                                                                                            
                                                                                                h.arrConsulta[h.arrConsulta.length]=arrValor;
                                                                                                
                                                                                                generarSentenciaConsultaOperacion();
                                                                                            }
                                                                                 },
                                                                                 '-',
                                                                                {
                                                                                    xtype:'button',
                                                                                    text:')',
                                                                                    handler:function()
                                                                                          {
                                                                                              var arrValor=new Array();
                                                                                              arrValor[0]=')';
                                                                                              arrValor[1]=')';
                                                                                              arrValor[2]=1;
                                                                                              h.arrConsulta[h.arrConsulta.length]=arrValor;
                                                                                              generarSentenciaConsultaOperacion();
                                                                                          }
                                                                               } ,
                                                                                 '-'
                                                                                ,
                                                                               
                                                                                {
                                                                                     xtype:'button',
                                                                                     text:'+',
                                                                                     handler:function()
                                                                                            {
                                                                                                var arrValor=new Array();
                                                                                                arrValor[0]='+';
                                                                                                arrValor[1]='+';
                                                                                                arrValor[2]=1;
                                                                                                h.arrConsulta[h.arrConsulta.length]=arrValor;
                                                                                                generarSentenciaConsultaOperacion();
                                                                                            }
                                                                                 },
                                                                                 '-'
                                                                                
                                                                               ,
                                                                                
                                                                                {
                                                                                   xtype:'button',
                                                                                   text:'-',
                                                                                   handler:function()
                                                                                          {
                                                                                              var arrValor=new Array();
                                                                                              arrValor[0]='-';
                                                                                              arrValor[1]='-';
                                                                                              arrValor[2]=1;
                                                                                              h.arrConsulta[h.arrConsulta.length]=arrValor;
                                                                                              generarSentenciaConsultaOperacion();
                                                                                          }
                                                                               },
                                                                                '-'
                                                                                ,
                                                                                {
                                                                                   xtype:'button',
                                                                                   text:'X',
                                                                                   handler:function()
                                                                                          {
                                                                                              var arrValor=new Array();
                                                                                              arrValor[0]='*';
                                                                                              arrValor[1]='X';
                                                                                              arrValor[2]=1;
                                                                                              h.arrConsulta[h.arrConsulta.length]=arrValor;
                                                                                              generarSentenciaConsultaOperacion();
                                                                                          }
                                                                               },
                                                                               '-'
                                                                               ,
                                                                                
                                                                                {
                                                                                   xtype:'button',
                                                                                   text:'/',
                                                                                   handler:function()
                                                                                          {
                                                                                              var arrValor=new Array();
                                                                                              arrValor[0]='/';
                                                                                              arrValor[1]='/';
                                                                                              arrValor[2]=1;
                                                                                              h.arrConsulta[h.arrConsulta.length]=arrValor;
                                                                                              generarSentenciaConsultaOperacion();
                                                                                          }
                                                                               }
                                                                                
                                                                    ],
                                                                    
                                                                    
                                                            items:	[
                                                                        {
                                                                            id:'txtConsulta',
                                                                            xtype:'textarea',
                                                                            x:10,
                                                                            y:105,
                                                                            width:410,
                                                                            height:170,
                                                                            readOnly:true
                                                                        }
                                                                    ]
                                                        }
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        
                                                    ]
                                        }
                                    );

    var ventana = new Ext.Window(
                                    {
                                        title: 'Insertar campo de operaci&oacute;n',
                                        width: 450,
                                        height:380,
                                        minWidth: 300,
                                        minHeight: 100,
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
                                                                    Ext.getCmp('txtNombreCampo').focus();
                                                                }
                                                            }
                                                },
                                        buttons:	[
                                                        {
                                                            text: 'Aceptar',
                                                            listeners:	{
                                                                            click:function()
                                                                                {
                                                                                    var nombre=Ext.getCmp('txtNombreCampo').getValue();
                                                                                    if(nombre=='')
                                                                                    {
                                                                                        function resp()
                                                                                        {
                                                                                            Ext.getCmp('txtNombreCampo').focus();
                                                                                        }
                                                                                        msgBox('El ID del campo es obligatorio',resp);
                                                                                        return;
                                                                                    }
                                                                                    
                                                                                    var txtConsulta=Ext.getCmp('txtConsulta').getValue();
                                                                                    if(!validarConsulta(txtConsulta))
                                                                                    {
                                                                                        function resp()
                                                                                        {
                                                                                            Ext.getCmp('txtNombreCampo').focus();
                                                                                        }
                                                                                        msgBox('La expresi&oacute;n ingresada no es v&aacute;lida',resp);
                                                                                        return;
                                                                                    }
                                                                                    var x;
                                                                                    var arrTokens='';
                                                                                    var token='';
                                                                                    
                                                                                    if(validarExpresion(h.arrConsulta)=='NaN')
                                                                                    {
                                                                                        msgBox('La expresi&oacute;n ingresada no es v&aacute;lida, favor de verificarla');
                                                                                        return;
                                                                                    }
                                                                                    
                                                                                    for(x=0;x<h.arrConsulta.length;x++)
                                                                                    {
                                                                                        token='{"tokenUsr":"'+cv(h.arrConsulta[x][1])+'","tokenApp":"'+cv(h.arrConsulta[x][0])+'","tipoToken":"'+cv(h.arrConsulta[x][2])+'"}';
                                                                                        if(arrTokens=='')
                                                                                            arrTokens=token;
                                                                                        else
                                                                                            arrTokens+=','+token;
                                                                                        
                                                                                    }
                                                                                    var idFormulario=gE('idFormulario').value;
                                                                                    var objFinal='{"idFormulario":"'+idFormulario+'","accion":"'+accion+'","nomCampo":"'+nombre+'","tipoElemento":"22","pregunta":"","obligatorio":"0","posX":"@posX","posY":"@posY","arrTokens":['+arrTokens+']}';
                                                                                    if((idControl=='-1')||(idControl==undefined))
	                                                                                    h.objControl=objFinal;
                                                                                    else
                                                                                    	h.guardarPregunta(objFinal);
                                                                                    ventana.close();
                                                                                }
                                                                        }
                                                        },
                                                        {
                                                            text: 'Cancelar',
                                                            handler:function()
                                                                    {
                                                                        ventana.close();
                                                                    }
                                                        }
                                                    ]
                                    }
                                );
        if(accion=='-1')                                
            ventana.show();
        else
            llenarConsultaCampoFormula(ventana);
}

function llenarConsultaCampoFormula(ventana)
{
    var div=h.gE(h.idDivSel);
    var nControl=div.getAttribute('controlInterno');
    var arrNom=nControl.split('_');
    var nombreCtrl='_'+arrNom[1];
    h.arrConsulta=eval(h.gE('exp_'+nombreCtrl).value);
    generarSentenciaConsultaOperacion();
    ventana.show();
}

function validarConsulta(consulta)
{
    return true;

}

//1 valor constante
//2 valor de campo
//3 valor de consulta

function generarSentenciaConsultaOperacion()
{
    var x;
    var txtConsulta='';
    sentenciaMysql='';
    for(x=0;x<h.arrConsulta.length;x++)
    {
        txtConsulta+=' '+h.arrConsulta[x][1];
    }
    Ext.getCmp('txtConsulta').setValue(txtConsulta);
}

function mostrarVentanaValor()
{
    var form = new Ext.form.FormPanel(	
                                        {
                                            baseCls: 'x-plain',
                                            layout:'absolute',
                                            defaultType: 'textfield',
                                            items: 	[
                                                        {
                                                            x:10,
                                                            y:10,
                                                            html:'Valor a insertar:',
                                                            xtype:'label'
                                                        },
                                                        {
                                                            id:'txtValorIns',
                                                            x:110,
                                                            y:5,
                                                            xtype:'numberfield',
                                                            allowDecimals:true
                                                        }
                                                        
                                                    ]
                                        }
                                    );

    


    var ventana = new Ext.Window(
                                    {
                                        title: 'Agregar valor constante',
                                        width: 300,
                                        height:120,
                                        minWidth: 300,
                                        minHeight: 100,
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
                                                                    Ext.getCmp('txtValorIns').focus(false,500);
                                                                }
                                                            }
                                                },
                                        buttons:	[
                                                        {
                                                            id:'btnAceptar',
                                                            text: 'Aceptar',
                                                            listeners:	{
                                                                            click:function()
                                                                                {
                                                                                    var valor=Ext.getCmp('txtValorIns').getValue();
                                                                                    if(valor=='')
                                                                                    {
                                                                                        function resp()
                                                                                        {
                                                                                            Ext.getCmp('txtValorIns').focus();
                                                                                        }
                                                                                        msgBox('El valor ingresado no es v&aacute;lido',resp);
                                                                                        return;
                                                                                    }	
                                                                                    var arrValor=new Array();
                                                                                    arrValor[0]= valor;
                                                                                    arrValor[1]= valor;
                                                                                    arrValor[2]= 1;
                                                                                    h.arrConsulta[h.arrConsulta.length]=arrValor;
                                                                                   
                                                                                    generarSentenciaConsultaOperacion();
                                                                                    ventana.close();
                                                                                    
                                                                                }
                                                                        }
                                                        },
                                                        {
                                                            text: 'Cancelar',
                                                            handler:function()
                                                                    {
                                                                        ventana.close();
                                                                    }
                                                        }
                                                    ]
                                    }
                                );
        ventana.show();
}

function mostrarVentanaControlFormulario()
{
    
    var alOpciones=		new Ext.data.SimpleStore(
                                                    {
                                                        fields:	[
                                                                    {name:'id'},
                                                                    {name:'campo'}
                                                                ]
                                                    }
                                                );
    var dsOpciones= [];
    alOpciones.loadData(dsOpciones);
    var chkModel=new Ext.grid.CheckboxSelectionModel();
    var cmFrmDTD= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer(),
                                                        chkModel,
                                                        {
                                                            header:'Campo',
                                                            width:500,
                                                            dataIndex:'campo'
                                                        }
                                                       
                                                    ]
                                                );
    
    
    var tblOpciones=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridTabla',
                                                            store:alOpciones,
                                                            frame:true,
                                                            clicksToEdit: 2,
                                                            cm: cmFrmDTD,
                                                            sm:chkModel,
                                                            height:300,
                                                            width:600
                                                        }
                                                    );
    
    panelGrid=new Ext.Panel	(
                                {
                                    y:10,
                                    items:	[
                                                tblOpciones
                                            ]
                                }
                            );
                            
    
    
    var form = new Ext.form.FormPanel(	
                                        {
                                            baseCls: 'x-plain',
                                            layout:'absolute',
                                            defaultType: 'textfield',
                                            items: 	[
                                                        panelGrid
                                                    ]
                                        }
                                    );
    
    

    
    
    
    btnSiguiente=new Ext.Button	(
                                    {
                                        text: 'Aceptar',
                                        minWidth:80,
                                        id:'btnFinalizar',
                                        listeners:	{
                                                        click:
                                                                {
                                                                    fn:function()
                                                                    {
                                                                    	var fila=tblOpciones.getSelectionModel().getSelected();
                                                                        if(fila==null)
                                                                        {
                                                                            msgBox('Debe seleccionar el campo a agregar');
                                                                            return;
                                                                        }
                                                                        else
                                                                        {
                                                                            var arrValor=new Array();
                                                                            arrValor[0]= fila.get('id');
                                                                            arrValor[1]= fila.get('campo');
                                                                            arrValor[2]= 2;
                                                                            h.arrConsulta[h.arrConsulta.length]=arrValor;
                                                                            generarSentenciaConsultaOperacion();
                                                                            ventanaSelCol.close();
                                                                            
                                                                        }
                                                                    }
                                                                }
                                                    }
                                    }
                                )
    
    ventanaSelCol = new Ext.Window(
                                            {
                                                title: 'Seleccione el campo que ser&aacute; su origen de datos',
                                                width: 620 ,
                                                height:400,
                                                minWidth: 300,
                                                minHeight: 100,
                                                layout: 'fit',
                                                plain:true,
                                                modal:true,
                                                bodyStyle:'padding:5px;',
                                                buttonAlign:'center',
                                                items: 	[
                                                            form
                                                        ],
                                                listeners : {
                                                            show : {
                                                                        buffer : 10,
                                                                        fn : function() 
                                                                        {
                                                                               
                                                                        }
                                                                    }
                                                        },
                                                buttons:	[
                                                                btnSiguiente,
                                                                {
                                                                    text: '<?php echo $etj["lblBtnCancelar"] ?>',
                                                                    handler:function()
                                                                    {
                                                                        
                                                                        ventanaSelCol.close();
                                                                    }
                                                                }
                                                            ]
                                            }
                                        );
//	ventanaSelCol.show();
    cargarCamposForm(alOpciones,ventanaSelCol);	
}

function cargarCamposForm(dSet,ventana)
{
    var idFormulario=gE('idFormulario').value;
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var arrCampos=eval(arrResp[1]);
            dSet.loadData(arrCampos);
            ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
     obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=40&idFormulario='+idFormulario,true);
}

function mostrarVentanaGenerarConsulta()
{
}

function validarExpresion(arrExp)
{
    var x;
    var expresionFinal='';
    for(x=0;x<arrExp.length;x++)
    {
        if(arrExp[x][2]=='1')
            expresionFinal+=arrExp[x][0];
        else
        {
            if(arrExp[x][2]=='2')
            {
                var valor=h.obtenerValorCampo(arrExp[x][0]);
                if (valor=="")
                    valor=0;
                expresionFinal+=valor;
            }
        }
    }
    try
    {
        var resultado=eval(expresionFinal);
    }
    catch(e)
    {
        var resultado='NaN';
    }
    return resultado;
}


function mostrarVentanaParametroFormulario()
{
    var form = new Ext.form.FormPanel(	
                                        {
                                            baseCls: 'x-plain',
                                            layout:'absolute',
                                            defaultType: 'textfield',
                                            items: 	[
                                                        {
                                                            x:10,
                                                            y:10,
                                                            html:'Nombre del param&aacute;metro:',
                                                            xtype:'label'
                                                        },
                                                        {
                                                            id:'txtParametro',
                                                            x:140,
                                                            y:5,
                                                            xtype:'textfield'
                                                        }
                                                        
                                                    ]
                                        }
                                    );

    


    var ventana = new Ext.Window(
                                    {
                                        title: 'Agregar valor de parametro de formulario',
                                        width: 300,
                                        height:120,
                                        minWidth: 300,
                                        minHeight: 100,
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
                                                                    Ext.getCmp('txtParametro').focus(false,500);
                                                                }
                                                            }
                                                },
                                        buttons:	[
                                                        {
                                                            id:'btnAceptar',
                                                            text: 'Aceptar',
                                                            listeners:	{
                                                                            click:function()
                                                                                {
                                                                                    var valor=Ext.getCmp('txtParametro').getValue();
                                                                                    if(valor=='')
                                                                                    {
                                                                                        function resp()
                                                                                        {
                                                                                            Ext.getCmp('txtParametro').focus();
                                                                                        }
                                                                                        msgBox('El valor ingresado no es v&aacute;lido',resp);
                                                                                        return;
                                                                                    }	
                                                                                    var arrValor=new Array();
                                                                                    arrValor[0]= '['+valor+']';
                                                                                    arrValor[1]= '['+valor+']';
                                                                                    arrValor[2]= 1;
                                                                                    h.arrConsulta[h.arrConsulta.length]=arrValor;
                                                                                   
                                                                                    generarSentenciaConsultaOperacion();
                                                                                    ventana.close();
                                                                                    
                                                                                }
                                                                        }
                                                        },
                                                        {
                                                            text: 'Cancelar',
                                                            handler:function()
                                                                    {
                                                                        ventana.close();
                                                                    }
                                                        }
                                                    ]
                                    }
                                );
        ventana.show();
}
