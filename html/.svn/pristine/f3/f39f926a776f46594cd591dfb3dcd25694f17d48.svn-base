<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	

	
?>

var arrCriterioAsignacion=	[	
                                ['1','Imputado se encuentra en libertad'],
                                ['2','Imputado privado de libertad, interno en reclusorio'],
                                ['3','Selecci&oacute;n manual por responsable de unidad']
                            ];

Ext.onReady(inicializar);


function inicializar()
{
	if(esRegistroFormulario())
    {
    
        asignarEvento('opt_privadoLibertadvch_1','click',function()
                                                            {
                                                            	selElemCombo(gE('_unidadEjecucionDestinovch'),'-1');
                                                                gEN('_criterioUnidadDestinovch')[0].value='3';
                                                                gE('sp_8038').innerHTML=formatearValorRenderer(arrCriterioAsignacion,gEN('_criterioUnidadDestinovch')[0].value);
                                                            }
                    );
        
        asignarEvento('opt_privadoLibertadvch_2','click',function()
                                                            {

                                                            	selElemCombo(gE('_unidadEjecucionDestinovch'),'009');
                                                                gEN('_criterioUnidadDestinovch')[0].value='1';
                                                                gE('sp_8038').innerHTML=formatearValorRenderer(arrCriterioAsignacion,gEN('_criterioUnidadDestinovch')[0].value);
                                                            }
                    );
        
         asignarEvento('opt_privadoLibertadvch_3','click',function()
                                                            {
                                                            	selElemCombo(gE('_unidadEjecucionDestinovch'),'-1');
                                                                
                                                            }
                    );
        
        asignarEvento('_unidadEjecucionDestinovch','change',function()
                                                            {
                                                                gEN('_criterioUnidadDestinovch')[0].value='3';
                                                                gE('sp_8038').innerHTML=formatearValorRenderer(arrCriterioAsignacion,gEN('_criterioUnidadDestinovch')[0].value);
                                                            }
                    );
                    
        asignarEvento('_lugarInternamientovch','change',function()
                                                            {
	                                                            var elemSel=gE('_lugarInternamientovch').options[gE('_lugarInternamientovch').selectedIndex].value;
                                                                var unidadEjecucion='';
                                                                switch(elemSel)
                                                                {
                                                                	case '00020001'://Norte
                                                                    	unidadEjecucion='501';
                                                                    break;
                                                                    case '00020002': //Oriente
                                                                    	unidadEjecucion='601';
                                                                    break;
                                                                    case '00020003': //Sur
                                                                    	unidadEjecucion='601';
                                                                    break;
                                                                    case '00020008': //Santha marta
                                                                    	unidadEjecucion='601';
                                                                    break;
                                                                }
                                                                if(unidadEjecucion!='')
                                                                {
                                                                    selElemCombo(gE('_unidadEjecucionDestinovch'),unidadEjecucion);
                                                                    gEN('_criterioUnidadDestinovch')[0].value='2';
                                                                    gE('sp_8038').innerHTML=formatearValorRenderer(arrCriterioAsignacion,gEN('_criterioUnidadDestinovch')[0].value);
                                                                        
                                                                    
                                                            	}
                                                                else
                                                                {
                                                                	selElemCombo(gE('_unidadEjecucionDestinovch'),'-1');
                                                                    gEN('_criterioUnidadDestinovch')[0].value='3';
                                                                    gE('sp_8038').innerHTML=formatearValorRenderer(arrCriterioAsignacion,gEN('_criterioUnidadDestinovch')[0].value);
                                                                }
                                                            }
                    );          
	                    
                    
    
    }
    else
    {
    	gE('sp_8038').innerHTML=formatearValorRenderer(arrCriterioAsignacion,gEN('_criterioUnidadDestinovch')[0].value);
    	if(gE('sp_8016').innerHTML=='')
        {
        	oE('div_8011');
        }
    }
    
}