<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

var tipoPaticipante;

function inyeccionCodigo()
{
	if(!esRegistroFormulario())
    {
    	if(gE('sp_7053').innerHTML=='Parte/Figura jurídica')
        {
        	oE('div_7055');
            oE('div_7059');
            
            oE('div_7071');//juzgado,tribunal colegiado,unitario
            oE('div_7075');//Sala penal
            oE('div_7077');//juez
            oE('div_7076');//unidad de gestion
            oE('div_7078');//otro
            if(gE('sp_7058').innerHTML!='Otro')
            {
            	oE('div_7065');
                oE('div_7066');
                oE('div_7067');
                oE('div_7069');
                oE('div_7068');
                oE('div_7070');
            }
            else
            {
            	oE('div_7064');
                
            }
            
        }
        else
        {
        	oE('div_7054');
            oE('div_7058');
            oE('div_7064');
            oE('div_7065');
            oE('div_7066');
            oE('div_7067');
            oE('div_7069');
            oE('div_7068');
            oE('div_7070');
            switch(gE('sp_7059').innerHTML)
            {
            	case 'Juzgado':
                case 'Tribunal colegiado':
                case 'Tribunal unitario':
                	
                    oE('div_7075');//Sala penal
                    oE('div_7077');//juez
                    oE('div_7076');//unidad de gestion
                    oE('div_7078');//otro
                break;
                case 'Sala penal':
                	oE('div_7071');//juzgado,tribunal colegiado,unitario
                    
                    oE('div_7077');//juez
                    oE('div_7076');//unidad de gestion
                    oE('div_7078');//otro
                break;
                case 'Juez del fuero común':
                	oE('div_7071');//juzgado,tribunal colegiado,unitario
                    oE('div_7075');//Sala penal
                   
                    oE('div_7076');//unidad de gestion
                    oE('div_7078');//otro
                break;
                case 'Unidad de gestión':
                	oE('div_7071');//juzgado,tribunal colegiado,unitario
                    oE('div_7075');//Sala penal
                    oE('div_7077');//juez
                    
                    oE('div_7078');//otro
                break;
                case 'Otra dependencia':
                	oE('div_7071');//juzgado,tribunal colegiado,unitario
                    oE('div_7075');//Sala penal
                    oE('div_7077');//juez
                    oE('div_7076');//unidad de gestion
                    
                break;
            }
        }
        
        gE('sp_7138').innerHTML=Ext.util.Format.number(gE('sp_7138').innerHTML,'0');
    	gE('sp_7140').innerHTML=Ext.util.Format.number((parseFloat(gE('_[totalCopias]flo').innerHTML)-parseFloat(gE('sp_7138').innerHTML)),'0');
    }
    else
    {
    	if(gE('idRegistroG').value=='-1')
	    	gEN('_carpetaAdministrativavch')[0].value=gE('sp_7057').innerHTML;
    }
    
}
  