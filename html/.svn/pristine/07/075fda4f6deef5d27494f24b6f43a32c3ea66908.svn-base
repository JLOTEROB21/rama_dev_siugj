<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$arrExtImgValidas=explode("|",$imgExtValidas);
	$nExtensiones=sizeof($arrExtImgValidas);
	$arrValidacion="";
	for($x=0;$x<$nExtensiones;$x++)
	{
		$cad="(extension=='.".strtolower($arrExtImgValidas[$x])."')";
		if($arrValidacion=="")
			$arrValidacion=$cad;
		else
			$arrValidacion.="||".$cad;
	}
?>

function mostrarVentanaImagenes()
{
    
    fp = new Ext.FormPanel	(
                                {
                                    fileUpload: true,
                                    width: 500,
                                    frame: true,
                                    bodyStyle: 'padding: 10px 10px 0 10px;',
                                    labelWidth: 100,
                                    defaults: 	{
                                                   
                                                    msgTarget: 'side'
                                                },
                            
                                    items:	[
                                    			{
														
														xtype: 'textfield',
														id: 'idControl',
                                                        width:130,
														fieldLabel: 'ID Control',
                                                        maskRe:/^[a-zA-Z0-9]$/
													
												},
                                                {
                                                    xtype: 'fileuploadfield',
                                                    id: 'form-file',
                                                    emptyText: 'Elija una Imagen',
                                                    fieldLabel: 'Imagen',
                                                    name: 'image',
                                                    buttonText: '',
                                                     width:'100%',
                                                    buttonCfg: 	{
                                                                    iconCls: 'upload-icon'
                                                                }
                                                },
                                                 {
                                                     xtype:'hidden',
                                                     name:'tipoArchivo',
                                                     value:1
                                                 }
                                                 
                                                 
                                            ]
                                }
                            );

    ventana=new Ext.Window(
                                {
                                    title:'Insertar Imagen',
                                    width:450,
                                    height:170,
                                    layout:'fit',
                                    buttonAlign:'center',
                                    items:[fp],
                                    modal:true,
                                    plain:true,
                                    listeners:
                                                {
                                                    show:
                                                            {
                                                                buffer:10,
                                                                fn:function()
                                                                        {
                                                                            
                                                                        }
                                                            }
                                                },
                                        buttons: 	[
                                                        {
                                                            text: 'Agregar',
                                                            handler: function()
                                                                    {
                                                                    	
                                                                        archivo=gE('form-file-file');
                                                                        archivoName=archivo.value;
                                                                        var extension = (archivoName.substring(archivoName.lastIndexOf("."))).toLowerCase();
                                                                        var idControl=Ext.getCmp('idControl').getValue();
                                                                        if(idControl=='')
                                                                        {
                                                                        	function respID()
                                                                            {
                                                                            	Ext.getCmp('idControl').focus();
                                                                            }
                                                                            msgBox('El ID del control es obligatorio',respID);
                                                                            return;
                                                                        }
                                                                        if(<?php echo $arrValidacion ?>)
                                                                        {
                                                                               fp.getForm().submit	(	
                                                                                                        {
                                                                                                            url: '../media/guardarImagenFormulario.php',
                                                                                                            waitMsg: 'Subiendo imagen...',
                                                                                                            success: function (fp,o)
                                                                                                            			{
                                                                                                                        	var idArchivo=o.result.idArchivo;
                                                                                                                            var ancho=o.result.ancho;
                                                                                                                            var alto=o.result.alto;
                                                                                                                            objControl='{"idPadre":"@idPadre","idReporte":"'+idReporte+'","pregunta":null,"tipoElemento":"23","nomCampo":"'+idControl+'","obligatorio":"0","posX":"@posX","posY":"@posY","idImagen":"'+idArchivo+'","confCampo":{"ancho":"'+ancho+'","alto":"'+alto+'"}}';
                                                                                                                            ventana.close();
                                                                                                                            
                                                                                                                        },
                                                                                                            failure: function (fp,o)
                                                                                                            		{
                                                                                                                    	function funcResp()
                                                                                                                        {
                                                                                                                            ventana.close();
                                                                                                                        }
                                                                                                                        Ext.MessageBox.alert(lblAplicacion,'No se ha podido guardar el archivo debido al siguiente problema: <br>'+o.result.error,funcResp);
                                                                                                                    }
                                                                                                        }
                                                                                                    );
                                                                            
                                                                        }
                                                                        else
                                                                        {
                                                                            Ext.MessageBox.alert('Error de Archivo', 'El archivo ingresado no es v\u00e1lido');
                                                                        
                                                                        }
                                                            
                                                                    }
                                                        },
                                                        {
                                                            text: 'Cancelar',
                                                            handler: function()
                                                                    {
                                                                        ventana.close();
                                                                    }
                                                        }
                                                    ]
                                }
                           )
    ventana.show();
}