<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>


Ext.onReady(inicializar);

function inicializar()
{
	$('#container').masonry({
      itemSelector: '.cBox',
      columnWidth: 300
    });
	return;
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'menu'},
                                                        {name:'orden', type:'int'}
                                                        
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                              reader: lector,
                                              proxy : new Ext.data.HttpProxy	(
                                                                                    {
                                                                                        url: '../paginasFunciones/funcionesPortal.php'                                                                                    
                                                                                    }
                                                                                ),
                                              sortInfo: {field: 'orden', direction: 'ASC'},
                                              groupField: 'menu',
                                              remoteGroup:false,
                                              remoteSort: false,
                                              autoLoad:true
                                              
                                          }) 
                                          
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='83';
                                    }                                          
				)                                    
                                          
	var resultTpl=new Ext.XTemplate(
                                        '<tpl for=".">',
                                        '<div class="thumb-wrap">',
                                            '<table width="200" >',
                                            '<tr>',
                                            	'<td>{menu}</td>',
                                            '</tr>',
                                            '</table>',
                                        '</div></tpl>'
                                    );                                              
	 var tblGrid=new Ext.DataView({
     								id:'gridTablero',
                                    tpl: resultTpl,
                                    width:950,
                                    autoHeight:true,
                                    height:450,
                                    renderTo:'tblTablero',
                                    store: alDatos,
                                    multiSelect: true,
                                    overClass:'x-view-over',
                                    itemSelector: 'div.thumb-wrap'
                                }) 

	                             
    
}

function lanzarAlerta()
{
	alert('ok');
}