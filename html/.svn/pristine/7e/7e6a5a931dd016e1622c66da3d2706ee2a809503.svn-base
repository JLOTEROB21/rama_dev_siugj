<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	
	
?>
var idFuncionBusqueda=new Date().format('YmdHis')+generarNumeroAleatorio(1000,9999);
var tipoFiguraBuqueda=[['0','Cualquiera'],['5','Defensor'],['4','Imputado'],['6','Representante legal'],['2','V\xEDctima']];

Ext.onReady(inicializar);

function inicializar()
{
	
	gEx('toolBar_2').add	(
    
    							{
                                	xtype:'label',
                                    html:'<span style="color:#000"><b>Nombre del participante:</b></span>&nbsp;&nbsp;'
                                }
    						)
	
    
    var comboTipoFigura=crearComboExt('op1_'+idFuncionBusqueda,tipoFiguraBuqueda,0,0,160,{valor:'0'});
    gEx('toolBar_2').add	(
    							comboTipoFigura
    						)
	gEx('toolBar_2').add	(
    							new Ext.form.TextField({"id":'filtro1_'+idFuncionBusqueda,width:"220",value:"", enableKeyEvents:true})
    						)
	gEx('toolBar_2').add	(
    							{
                                	id:'btnClean_'+idFuncionBusqueda+'_1',
                                    icon:"../images/find_remove.png",
                                    border:true,
                                    width:20,
                                    cls:"x-btn-text-icon",
                                    handler:function(btn)
                                    {
                                    	limpiarFiltro(btn)
                                    }
                                 }
    						)
	
    gEx('toolBar_2').add	(
    							'-'
    						)
                            
	arrIdFiltros.push(['filtro1_'+idFuncionBusqueda,idFuncionBusqueda,'10','','1']);   //110 funcion Busqueda
    
    gEx('btnClean_'+idFuncionBusqueda+'_1').on('select',	function(cmb,registro)
    									{
                                        	var idFiltro='filtro1_'+idFuncionBusqueda;
                                            controlOperadorCambio(idFiltro);
                                        }
                              ); 
    gEx('filtro1_'+idFuncionBusqueda).idFuncionBusqueda=425;                        
  	gEx('filtro1_'+idFuncionBusqueda).campoBusquedaFuncion=true;                                                 
    gEx('filtro1_'+idFuncionBusqueda).on('change',realizarBusquedaParticipante); 
    gEx('filtro1_'+idFuncionBusqueda).on('specialkey',function(field, e)
                                                      {
                                                           if ((e.getKey() == e.ENTER)||(e.getKey() == e.TAB))
                                                           {
                                                              realizarBusquedaParticipante();
                                                           }
                                                      }
                                       	);
    
    
    
                         
    gEx('toolBar_2').show();
    gEx('filtro1_'+idFuncionBusqueda).valorAnterior='';
    gEx('panel_1').setHeight(gEx('panel_1').getHeight()+35);
}


function realizarBusquedaParticipante()
{
	if(gEx('filtro1_'+idFuncionBusqueda).getValue()!=gEx('filtro1_'+idFuncionBusqueda).valorAnterior )
    {
		recargarGridRegistros();
        gEx('filtro1_'+idFuncionBusqueda).valorAnterior=gEx('filtro1_'+idFuncionBusqueda).getValue();
    }
}
