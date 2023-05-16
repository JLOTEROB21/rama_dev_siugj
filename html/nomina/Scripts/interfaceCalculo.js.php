<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

Ext.onReady(inicializar);

function inicializar()
{

}


function cambioCmb(combo,id)
{
	var opcion=combo.options[combo.selectedIndex].value;
    if(opcion==3)
    {
    	mE('tablas_'+id);
        gE('tablas_'+id).setAttribute('val','obl');
        mE('campo_'+id);
        gE('campo_'+id).setAttribute('val','obl');
        mE('proyecta_'+id);
        gE('proyecta_'+id).setAttribute('val','obl');
    }
    else
    {
    	oE('tablas_'+id);
        gE('tablas_'+id).removeAttribute('val');
        oE('campo_'+id);
        gE('campo_'+id).removeAttribute('val');
        oE('proyecta_'+id);
        gE('proyecta_'+id).removeAttribute('val');
    }
}

function tablaCmb(combo,id)
{
	var opcion=combo.options[combo.selectedIndex].value;
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var cadCmb=arrResp[2];
            var arrCmb=eval(cadCmb);
            var combo=gE('campo_'+id);
			llenarCombo(combo,arrCmb,1);
            
            var combo2=gE('proyecta_'+id);
			llenarCombo(combo2,arrCmb,1);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=13&nomTabla='+opcion,true);
}

function guardarConf(formulario)
{
	if(validarFormularios(formulario))
    {
    	var cadenaLista=gE('listado').value;
        if(cadena=='')
        {
        	window.parent.close();
        }
        else
        {
        	var idCalculo=gE('idCalculo').value;
            var cadena='';
            var arreglo=cadenaLista.split(',')	;
            var tamano=arreglo.length;
            var x;
            for(x=0;x< tamano;x++)
            {
                var tabla=0;
                var campo=0;
                var proyecta=0;
                var idParametro=arreglo[x];
                var cmb=gE('opcion_'+idParametro);
                
                var tipoEntrada=cmb.options[cmb.selectedIndex].value;
                if(tipoEntrada==3)
                {
                	var cmb1=gE('tablas_'+idParametro);
                    var tabla=cmb1.options[cmb1.selectedIndex].value;
                    
                    var cmb2=gE('campo_'+idParametro);
                    var campo=cmb2.options[cmb2.selectedIndex].value;
                    
                    var cmb3=gE('proyecta_'+idParametro);
                    var proyecta=cmb3.options[cmb3.selectedIndex].value;
                }
                
                if(cadena=='')    
                	cadena=idParametro+'@'+tipoEntrada+'@'+tabla+'@'+campo+'@'+proyecta;
                else
                	cadena+=','+idParametro+'@'+tipoEntrada+'@'+tabla+'@'+campo+'@'+proyecta;    
            }
            function funcAjax()
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
                    window.parent.tb_remove();
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProgAcademico.php',funcAjax, 'POST','funcion=22&cadena='+cadena+'&idCalculo='+idCalculo,true);
        }
    }

}



