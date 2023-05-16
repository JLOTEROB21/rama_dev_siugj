<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$idReferencia=($_GET["iRef"]);
	
	$consulta="SELECT tribunalAlzada FROM _487_tablaDinamica WHERE id__487_tablaDinamica=".$idRegistro;
	$tribunalAlzada=$con->obtenerValor($consulta);
?>	

var existeAudiencia=false;
var tribunalAlzada='<?php echo $tribunalAlzada?>';
var cadenaFuncionValidacion='funcionPrepararGuardado';

function inyeccionCodigo()
{
	
	if(esRegistroFormulario())
    {
    
    	if(gE('idRegistroG').value=='-1')
        {
        	setTimeout(	function()
            			{
				        	gEx('btnGuardarForm').hide();
                         },500);
        }
        
         asignarEvento(gE('_noTocavch'),'keypress',function()
                                                    {
                                                       gEx('btnGuardarForm').hide();
                                                    }
                                    );
        
		 asignarEvento(gE('_noTocavch'),'change',function()
                                                    {
                                                        validarExpediente();
                                                    }
                                    );
	}
}


function funcionPrepararGuardado()
{
	if(existeAudiencia)
    	return false;
    return true;
}


function validarExpediente()
{
	var cA=gE('_noTocavch').value;
    var tribunal=tribunalAlzada;
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        
        	if(arrResp[1]=='0')
            {
            	oE('div_9815');
                existeAudiencia=false;
                gEx('btnGuardarForm').show();
            }
            else
            {
            	existeAudiencia=true;
                mE('div_9815');
                gEx('btnGuardarForm').hide();
                switch(arrResp[1])
                {
                 	case '1':
                    	gE('sp_9815').innerHTML='El No. de Expediente ha sido registrado previamente !!!';
                    break;
                    case '2':
                    	gE('sp_9815').innerHTML='El No. de Expediente ya se encuentra registrado en otro registro de expediente!!!';
                    break;  
                    
                }
           	}
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Alzada.php',funcAjax, 'POST','funcion=5&iR='+gE('idRegistroG').value+'&t='+tribunal+'&cA='+cA,true);

    
    
}