<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

var arrVisores=	[
					['pdf','pdf_viewer.php'],
                    ['png','images_viewer.php'],
                    ['gif','images_viewer.php'],
                    ['jpg','images_viewer.php'],
                    ['jpeg','images_viewer.php']
                ];
Ext.onReady(inicializar);

function inicializar()
{
	
	var oDocumento=eval('['+bD(gE('datosDocumento').value)+']')[0];  
    
    oComp={};
   
    var objConf=	{
                        xtype:'panel',
                        region:'center',
                        layout:'border',
                        
                        items:	[
                                    new Ext.ux.IFrameComponent({ 
    
                                                                      id: 'frameContenido', 
                                                                      anchor:'100% 100%',
                                                                      region:'center',
                                                                      loadFuncion:function(iFrame)
                                                                                  {
                                                                                      
                                                                                  },
    
                                                                      url: '../paginasFunciones/white.php',
                                                                      style: 'width:100%;height:100%' 
                                                              })
                                ]
                    }
	
    var arrBar=null;                    
    if(gE('ocultarBarraSuperior').value=='0')                
	{
    	arrBar=		[
                      {
                          xtype:'label',
                          html:'<div class="letraNombreTableroNegro">Documento: <div class="letraNombreTablero" id="lblNombreDoc" title="'+oDocumento.nombreArchivo+'" alt="'+oDocumento.nombreArchivo+'">'+
                          		(oDocumento.nombreArchivo.length>40?oDocumento.nombreArchivo.substr(0,37)+'...':oDocumento.nombreArchivo)+'</label></div>'
                      },
                      {
                      	xtype:'tbspacer',
                        width:15
                      },
                      {
                          xtype:'label',
                          html:'<div class="letraNombreTableroNegro">Tama&ntilde;o: <div class="letraNombreTablero" id="lblTamano">'+(parseInt(oDocumento.tamano)==0?'Indeterminado':bytesToSize(parseInt(oDocumento.tamano),0))+'</div></div>'                      },
                      
                      {
                      	xtype:'tbspacer',
                        width:10
                      },
                      {
                          xtype:'label',
                          cls:'letraNombreTablero',
                          html:'<div class="letraNombreTableroNegro">Formato: <div class="letraNombreTablero" id="lblFormato">'+oDocumento.extension.toUpperCase()+'</div></div>' 
                      },
                      {
                      	xtype:'tbspacer',
                        width:10
                      },
                      {
                          xtype:'label',
                          cls:'letraNombreTablero',
                          html:'<div class="letraNombreTableroNegro">Fecha de registro: <div class="letraNombreTablero" id="lblFechaRegistro">'+Date.parseDate(oDocumento.fechaCreacion,'Y-m-d H:i:s').format('d/m/Y H:i')+' hrs.'+'</div></div>' 
                      },
                      {
                      	xtype:'tbspacer',
                        width:10
                      },
                      
                      {
                          icon:'../images/download.png',
                          cls:'x-btn-text-icon',
                          text:'Descargar',
                          handler:function()
                                  {
                                      location.href=oDocumento.urlContenido+'?id='+bE('documento_'+gE('iDocumento').value)+'&eV2='+gE('eV2').value+'&nombreArchivo='+oDocumento.nombreArchivo;
                                  }
                          
                      }
                      
                      
                      
                      
                  ];
    }                    

	objConf.cls='panelSiugj';
    if(!arrBar)
    	objConf.tbar=arrBar;
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                           objConf 
                                       ]
                            }
                        ) 
	
    var parametros={};
	var urlViewer='../visoresGaleriaDocumentos/';                        
	var pos=existeValorMatriz(arrVisores,'pdf');                        
	if(pos==-1)                        
    {
    	urlViewer+='noViewer.php';
    }
    else
    {
    	urlViewer+=arrVisores[pos][1];
        parametros={urlDoc:bE(oDocumento.urlContenido+'?id='+bE('1_'+gE('iDocumento').value)+'&nombreArchivo='+oDocumento.nombreArchivo)}
     }                   
	gEx('frameContenido').load	(
    
    								{
    									url:urlViewer,
                                        params:parametros	
                                     }
    							)                        
                          
}

