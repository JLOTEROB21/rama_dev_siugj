<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	
	
	$consulta="SELECT id__5_tablaDinamica,nombreTipo FROM _5_tablaDinamica";
	$arrTipoFigura=$con->obtenerFilasArreglo($consulta);
	
	$idActividad=-1;
	
	if($idRegistro==-1)
		$idActividad=generarIDActividad($idFormulario);


	$fechaActual=date("Y-m-d")	;
	$horaActual=date("H:i");
	
	
?>

var idActividad=<?php echo $idActividad?>;

var cadenaFuncionValidacion='validarDocumentacionSolicitada';



function inyeccionCodigo()
{
	
    if(esRegistroFormulario())
    {
    	
        
        asignarEvento(gE('_tipoProcesovch'),'change',function(cmb)
        							{
                                    	var opcion=cmb.options[cmb.selectedIndex].value;
                                        if(opcion=='5')
                                        {
                                        	oE('div_10438');
                                            oE('div_10439');
                                            oE('div_11364');
                                            gE('_cuantiaProcesoflo').setAttribute('val','');
                                        }
                                        else
                                        {
                                        	mE('div_10438');
                                            mE('div_10439');
                                            mE('div_11364');
                                            gE('_cuantiaProcesoflo').setAttribute('val','obl|flo');
                                        }
                                    }
        			);
        
        
        asignarEvento(gE('_cuantiaProcesoflo'),'blur',function()
        							{
                                    	convertirCuantiaLetra();
                                    }
        			); 
    	
                    
        loadScript('../Scripts/funcionesAjaxV2.js', function(){});
        
        loadCSS('../Scripts/classNotify/jquery.classynotty.css', function(){});
        loadScript('../Scripts/classNotify/jquery.classynotty.js', function(){});
        if(gE('idRegistroG').value=='-1')
            gEN('_idActividadvch')[0].value=idActividad;
        else
            idActividad=gEN('_idActividadvch')[0].value;
            
        if(gE('idRegistroG').value=='-1')
        {
        	
            
            if(gEx('f_sp_fechaRecepcionDemandadte'))
            {
             	gEx('f_sp_fechaRecepcionDemandadte').setValue('<?php echo $fechaActual?>');
             
             	gEx('f_sp_fechaRecepcionDemandadte').fireEvent('change', gEx('f_sp_fechaRecepcionDemandadte'), gEx('f_sp_fechaRecepcionDemandadte').getValue());
             	gEx('f_sp_fechaRecepcionDemandadte').fireEvent('select', gEx('f_sp_fechaRecepcionDemandadte'));
             }
             if(gEx('f_sp_horaRecepcionDemandatme'))
             {
	             gEx('f_sp_horaRecepcionDemandatme').setValue('<?php echo $horaActual?>');
             	gEx('f_sp_horaRecepcionDemandatme').fireEvent('change', gEx('f_sp_horaRecepcionDemandatme'), gEx('f_sp_horaRecepcionDemandatme').getValue());
             }
            
        }   
        else
        {
        	convertirCuantiaLetra();
        } 
        asignarEvento(gE('_claseProcesovch'),'change',function(combo)
                                                                        {
                                                                           	
                                                                            
                                                                            
                                                                            var opcionSel=combo.options[combo.selectedIndex].value;
                                                                            function funcAjax()
                                                                            {
                                                                                var resp=peticion_http.responseText;
                                                                                arrResp=resp.split('|');
                                                                                if(arrResp[0]=='1')
                                                                                {
                                                                                	var grid_10415=gEx('grid_10415');
                                                                                    var arrRegistros=eval(arrResp[1]);
                                                                                    var x;
                                                                                    var r;
                                                                                    var arrRegistrosExisten=[];
                                                                                    var pos;
                                                                                    var fila;
                                                                                    var reg=crearRegistro([{name: 'idRegistro'},{name: 'idReferencia'},{name:'idDocumento', type:'string'},{name:'presentaDocumento', type:'string'},{name:'documentoAdjunto', type:'string'},{name:'obligatorio', type:'string'}]);
                                                                                    for(x=0;x<arrRegistros.length;x++)
                                                                                    {
                                                                                    
                                                                                    	pos=obtenerPosFila(grid_10415.getStore(),'idDocumento',arrRegistros[x].idDocumento);
                                                                                    	if(pos==-1)
                                                                                    	{
                                                                                    		r=new reg(arrRegistros[x]);
                                                                                    		grid_10415.getStore().add(r);
                                                                                            arrRegistrosExisten.push(r);
                                                                                    	}
                                                                                        else
                                                                                        {
                                                                                        	arrRegistrosExisten.push(grid_10415.getStore().getAt(pos));
                                                                                        }
                                                                                    }
                                                                                    var enc;
                                                                                    var ct;
                                                                                    var filaEliminar=[];
                                                                                    for(x=0;x<grid_10415.getStore().getCount();x++)
                                                                                    {
                                                                                    	enc=false;
                                                                                    	fila=grid_10415.getStore().getAt(x);
                                                                                        for(ct=0;ct<arrRegistrosExisten.length;ct++)
                                                                                        {
                                                                                        	if(fila.data.idDocumento==arrRegistrosExisten[x].data.idDocumento)
                                                                                            {
                                                                                            	enc=true;
                                                                                                break;
                                                                                            }
                                                                                        }
                                                                                        
                                                                                        if(!enc)
                                                                                        {
                                                                                        	filaEliminar.push(fila);
                                                                                        }
                                                                                        
                                                                                        
                                                                                    }
                                                                                    
                                                                                	grid_10415.getStore().remove(filaEliminar);
                                                                                }
                                                                                else
                                                                                {
                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                }
                                                                            }
                                                                            obtenerDatosWeb('../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',funcAjax, 'POST','funcion=1&cP='+opcionSel,true);

                                                                        }
                                                        ); 
        
        
	
    	if((gEN('actorProceso')[0].value=='Njcz')||(gEN('actorProceso')[0].value=='MTMzOQ=='))
        {
        	oE('div_10088');
            oE('div_10089');
            oE('div_10090');
            
        }
    
    }
    else
    {
    	idActividad=gEN('_idActividadvch')[0].value;
       
    	if(gEN('actorProceso')[0].value=='MTMzOQ==')
        {
        	oE('div_10088');
            oE('div_10089');
            oE('div_10090');
            
        }
        
        if(gE('sp_10382').innerHTML=='Fuero Sindical')
        {
        	oE('div_10438');
            oE('div_10439');
            oE('div_11364');
        }
        convertirCuantiaLetra();	
    }
    	
    
    
}



function agregarParticipante(f,parte)
{
	var objConf={};

    objConf.idActividad=idActividad;
    objConf.idCarpeta=-1;
    objConf.afterRegister=recargarGridParticipantes;
   	objConf.ocultaCURP=true;
    objConf.ocultaCedula=true;
    objConf.ocultaRFC=true;
    objConf.ocultaAlias=true;
    
	agregarParticipanteVentana(f,parte,objConf)
}

function recargarGridParticipantes()
{
	gEx('gParticipantes').getStore().reload();
}

function editarParte(f,iR)
{
	var objConf={};
    objConf.idActividad=idActividad;
    objConf.idCarpeta=-1;
    objConf.afterRegister=recargarGridParticipantes;
    objConf.idParticipante=bD(iR);
    objConf.ocultaCURP=true;
    objConf.ocultaCedula=true;
    objConf.ocultaRFC=true;
    objConf.ocultaAlias=true;
    var pos=existeValorMatriz(arrTipoFigura,bD(f));
    var parte=arrTipoFigura[pos][1];
	agregarParticipanteVentana(bD(f),parte,objConf)
  
}




function validarDocumentacionSolicitada()
{
	var grid_10415=gEx('grid_10415');
    var x;
    var fila;
    for(x=0;x<grid_10415.getStore().getCount();x++)
    {
    	fila=grid_10415.getStore().getAt(x);
        
        if(fila.data.obligatorio=='1')
        {
        	if((fila.data.presentaDocumento=='0')&&(fila.data.documentoAdjunto==''))
            {
            	function resultado()
                {
                	gEx('editor_10415').startEditing(x);
                }
            	msgBox('El documento/requisito <b>'+formatearValorRenderer(arrTiposDocumentos,fila.data.idDocumento)+'</b> es obligatorio, debe ingresar el documento o marcarlo como presentado',resultado);
				return false;            	
            }
        }
        
    }
    
    return true;
    

}


function convertirCuantiaLetra()
{
	
    
    var valor=(gE('_cuantiaProcesoflo') && gE('_cuantiaProcesoflo').value)?gE('_cuantiaProcesoflo').value:gE('_cuantiaProcesoflo').innerHTML;
    var montoTotal=parseFloat(normalizarValor(valor));
	var arMonto=valor.split('.');
	var parteDecimal=0;
    
    valor=arMonto[0];
    
    if(arMonto.length>1)
    {
    	parteDecimal=parseInt(arMonto[1]);
    }
    
    if(parteDecimal<10)
    {
    	parteDecimal='0'+parteDecimal;
    }
    
     var leyenda='('+covertirNumLetras(parseFloat(normalizarValor(valor)))+' PESOS'+(parseFloat(parteDecimal)>0?' CON '+parteDecimal+' CENTAVOS':'')+')';
    
    if(montoTotal % 1000000==0)
    {

    	leyenda=leyenda.replace(' PESOS',' DE PESOS');
    }
    
	gE('sp_11364').innerHTML=leyenda;
}