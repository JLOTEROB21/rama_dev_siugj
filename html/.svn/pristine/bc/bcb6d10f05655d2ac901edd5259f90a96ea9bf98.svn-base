<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT * FROM _32_tablaDinamica";
	$arrTipoIdentificacion=$con->obtenerFilasJSON($consulta);
	
?>
var arrTipoIdentificacion=<?php echo $arrTipoIdentificacion?>;

class cValidacionDocumento
{
	
    
    constructor(IDCtrlTipoDocumento,IDCtrlNoIdentificacion)
    {
    	this.ultimaBusqueda='';
        this.ultimaValidacion='';
    	this.ctrlTipoDocumento=gEx(IDCtrlTipoDocumento);
        this.tipoCtrlTipoDocumento='ext';
        
        if(!this.ctrlTipoDocumento || !this.ctrlTipoDocumento.getValue)
        {
            this.ctrlTipoDocumento=gE(IDCtrlTipoDocumento);
            this.tipoCtrlTipoDocumento='html';
        }
        
        if(this.tipoCtrlTipoDocumento=='ext')
        {
            this.ctrlTipoDocumento.on('select',function(cmb,registro)
                                            {
                                                tipoDocumentoChangeValidacionDocumento(oValidacionDocumento,registro.data.id);
                                            }
                                )
        }
        else
        {
            asignarEvento(this.ctrlTipoDocumento,'change',function(ctrl)
                                                        {
                                                            tipoDocumentoChangeValidacionDocumento(oValidacionDocumento,ctrl.options[ctrl.selectedIndex].value);
                                                        }
                         );                     

        }
        
        
        this.ctrlNoIdentificacion=gEx('IDCtrlNoIdentificacion');
        this.tipoCtrlNoIdentificacion='ext';
        if(!this.ctrlNoIdentificacion || !this.ctrlNoIdentificacion.getValue)
        {
            this.tipoCtrlNoIdentificacion='html';
            this.ctrlNoIdentificacion=gE(IDCtrlNoIdentificacion);
        }


		if(this.tipoCtrlNoIdentificacion=='ext')
        {
        
        	this.ctrlNoIdentificacion.on('keypress',function(txt,e)
            										{
                                                    	txtNoDocumentoKeyPressExt(oValidacionDocumento,txt,e);
                                                    }
            							)
        
        	this.ctrlNoIdentificacion.on('blur',function(txt)		
            									{
                                                	if(txt.getValue()=='')
                                                        return;
                                                    
                                                    if(validarNoIdentificacionValidacionDocumento(oValidacionDocumento,1))
                                                    {  
                                                        if(this.ultimaBusqueda!=txt.getValue())
                                                        {
                                                            this.ultimaBusqueda=txt.getValue();
                                                            if(this.afterValidateDocument)
                                                            {
                                                                eval(this.afterValidateDocument+'(oValidacionDocumento,txt.getValue());');
                                                            }
                                                        }
                                                    }
                                                }
            							)
        }
        else
        {
        
        	
        
        	
            this.ctrlNoIdentificacion.setAttribute('onkeypress','return txtNoDocumentoKeyPressHTML(oValidacionDocumento,this,event)');
            this.ctrlNoIdentificacion.setAttribute('onblur','txtNoDocumentoBlurHTML(this)');

        	
        
        	
        }

    }
    
    tipoDocumentoGetValue()
    {
    	if(this.tipoCtrlTipoDocumento=='ext')
        {
        	return this.ctrlTipoDocumento.getValue();
        }
        else
        {
        	return this.ctrlTipoDocumento.options[this.ctrlTipoDocumento.selectedIndex].value
        }
    }
    
    noDocumentoGetValue()
    {
    	if(this.tipoCtrlNoIdentificacion=='ext')
        {
        	return this.ctrlNoIdentificacion.getValue();
        }
        else
        {
        	return this.ctrlNoIdentificacion.value
        }
    }
    
    
    tipoDocumentoSetValue(valor)
    {
    	if(this.tipoCtrlTipoDocumento=='ext')
        {
        	this.ctrlTipoDocumento.setValue(valor);
        }
        else
        {
        	selElemCombo(this.ctrlTipoDocumento,valor);
        }
    }
    
    noDocumentoSetValue(valor)
    {
    	if(this.tipoCtrlNoIdentificacion=='ext')
        {
        	this.ctrlNoIdentificacion.setValue(valor);
        }
        else
        {
        	this.ctrlNoIdentificacion.value=valor
        }
    }
    
    
     tipoDocumentoResetValue()
    {
    	if(this.tipoCtrlTipoDocumento=='ext')
        {
        	this.ctrlTipoDocumento.setValue('');
        }
        else
        {
        	this.ctrlTipoDocumento.selectedIndex=-1;
        }
    }
    
    noDocumentoResetValue()
    {
    	if(this.tipoCtrlNoIdentificacion=='ext')
        {
        	this.ctrlNoIdentificacion.setValue('');
        }
        else
        {
        	this.ctrlNoIdentificacion.value=''
        }
    }
    
    
    
    
    
}



function tipoDocumentoChangeValidacionDocumento(obj,tipoDocumento)
{
    if(obj.tipoCtrlNoIdentificacion=='ext')
    {
        obj.tipoCtrlNoIdentificacion.setValue('');
    }
    else
    {
        obj.tipoCtrlNoIdentificacion.value='';                    

    }
    
    obj.noDocumentoResetValue();
    obj.ctrlNoIdentificacion.focus();
    
    
    var pos=existeValorArregloObjetos(arrTipoIdentificacion,'id__32_tablaDinamica',''+tipoDocumento);
    var filaTipoDocumento=arrTipoIdentificacion[pos];
    if(obj.funcionAfterSelect)
    {
    	
        eval(obj.funcionAfterSelect+'('+tipoDocumento+');');
        
    }
    
    
    
    
}

function txtNoDocumentoKeyPressExt(obj,txt,e)
{
	if(e.charCode=='46')
    {
        e.stopEvent();
        return;
    }
    if(e.charCode=='13')
    {
        if(txt.getValue()=='')
            return;
        
        if(validarNoIdentificacionValidacionDocumento(obj,1))
        {   
        	if(obj.afterValidateDocument)
            {
            	eval(obj.afterValidateDocument+'(obj,txt,e);');
            }
        
            
        }
    }
    
    var tipoIdentificacion=obj.tipoDocumentoGetValue();
    var pos=existeValorArregloObjetos(arrTipoIdentificacion,'id__32_tablaDinamica',tipoIdentificacion);
    
    var filaDocumento=arrTipoIdentificacion[pos];
    
    if(patseInt(filaDocumento.maxLongitud)!='')
    {
        if((txt.getValue().length+1)>parseInt(filaDocumento.maxLongitud))
        {
            e.stopEvent();
        }
    }
    if(filaDocumento.caracteresPermitidos!='')
    {
        var re =null;
        
        eval('re=/['+filaDocumento.caracteresPermitidos+']/;');
        var caracter=String.fromCharCode(e.charCode);
        if(!re.test(caracter))
        {
            e.stopEvent();
        }
        
    }
}


function txtNoDocumentoKeyPressHTML(obj,txt,evt)
{
	var key = nav4 ? evt.which : evt.keyCode;
    
	if(key==46)
    {
        detenerEvento(evt);
        return false;
    }
    if(key==13)
    {
        if(txt.value=='')
            return true;
        
        if(validarNoIdentificacionValidacionDocumento(obj,1))
        {   
        	if(obj.afterValidateDocument)
            {
            	eval(obj.afterValidateDocument+'(obj,txt,e);');
            }
        
            
        }
    }
    
    var tipoIdentificacion=obj.tipoDocumentoGetValue();
    var pos=existeValorArregloObjetos(arrTipoIdentificacion,'id__32_tablaDinamica',tipoIdentificacion);
    var filaDocumento={};
    
	
    if(pos==-1)
    {
        filaDocumento.maxLongitud=10;
        filaDocumento.caracteresPermitidos='0-9A-Za-z';	
        
    }
    else
		filaDocumento=arrTipoIdentificacion[pos];
    
    if(parseInt(filaDocumento.maxLongitud)!='')
    {
        if((txt.value.length+1)>parseInt(filaDocumento.maxLongitud))
        {
            detenerEvento(evt);
            return false;
        }
    }
    if(filaDocumento.caracteresPermitidos!='')
    {
        var re =null;
        
        eval('re=/['+filaDocumento.caracteresPermitidos+']/;');
        var caracter=String.fromCharCode(key);
        if(!re.test(caracter))
        {
            detenerEvento(evt);
            return false;
        }
        
    }
}


function txtNoDocumentoBlurHTML(txt)
{
	if(txt.value=='')
        return;
    
    if(validarNoIdentificacionValidacionDocumento(oValidacionDocumento,1))
    {  
        if(oValidacionDocumento.ultimaBusqueda!=txt.value)
        {
            oValidacionDocumento.ultimaBusqueda=txt.value;
            if(oValidacionDocumento.afterValidateDocument)
            {
                eval(oValidacionDocumento.afterValidateDocument+'(oValidacionDocumento,txt.value);');
            }
        }
    }
}

function validarNoIdentificacionValidacionDocumento(obj,tipoValidacion)
{
	if(obj.ultimaValidacion==obj.noDocumentoGetValue())
    {
    	return;
    }

	obj.ultimaValidacion=obj.noDocumentoGetValue();
	var valor=obj.noDocumentoGetValue();
 	var tipoIdentificacion=obj.tipoDocumentoGetValue();
    var pos=existeValorArregloObjetos(arrTipoIdentificacion,'id__32_tablaDinamica',tipoIdentificacion);
    
    if(pos!=-1)
    {
    	var filaDocumento=arrTipoIdentificacion[pos];
        
        var re =null;
        
        eval('re=/['+filaDocumento.caracteresPermitidos+']{'+filaDocumento.minLogitud+','+filaDocumento.maxLongitud+'}$/;');
        var tipoCaracteres='';
        var permiteNumeros=false;
        var permiteLetras=false;
        
        if(filaDocumento.caracteresPermitidos.indexOf('0')!=-1)
        {
        	permiteNumeros=true;
        }
        
        if(filaDocumento.caracteresPermitidos.indexOf('a')!=-1)
        {
        	permiteLetras=true;
        }
        
        
        tipoCaracteres='caracteres';
        
        if(permiteNumeros && permiteLetras)
        {
        	tipoCaracteres+=' alfanum&eacute;ricos';
        }
        else
        {
            if(permiteNumeros)
            {
                tipoCaracteres+=' num&eacute;ricos';
            }
            else
                if(permiteLetras)
                {
                    tipoCaracteres+=' alfab&eacute;ticos';
                }
        }
        
        var lblLeyendaLongitud='';
        var leyendaFormato='';
        if(parseInt(filaDocumento.minLogitud)==parseInt(filaDocumento.maxLongitud))
        {
            leyendaFormato=filaDocumento.minLogitud+' '+tipoCaracteres;
            lblLeyendaLongitud='El n&uacute;mero de identificaci&oacute;n debe ser de '+leyendaFormato;
            
        }
        else
        {
            leyendaFormato='Entre '+parseInt(filaDocumento.minLogitud)+' a '+parseInt(filaDocumento.maxLongitud)+' '+tipoCaracteres;
            lblLeyendaLongitud='El n&uacute;mero de identificaci&oacute;n debe ser de entre '+parseInt(filaDocumento.minLogitud)+' a '+parseInt(filaDocumento.maxLongitud)+' '+tipoCaracteres;
        }
        
        if(tipoValidacion==1)
        {
            
            if((valor.length<parseInt(filaDocumento.minLogitud)) || (valor.length>parseInt(filaDocumento.maxLongitud)))
            {
                function resp()
                {
                    obj.ctrlNoIdentificacion.focus();
                }
                msgBox(lblLeyendaLongitud,resp);
                return false;
            }
            
            
            if(!re.test(valor))
            {
                function resp2()
                {
                    obj.ctrlNoIdentificacion.focus();
                }
               	window.parent.msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido ('+leyendaFormato+')',resp2);
                return false;
            }
            return true;
            
        }
        else
        {
            if(!re.test(valor))
            {
                function resp3()
                {
                    obj.ctrlNoIdentificacion.focus();
                }
                window.parent.msgBox('El n&uacute;mero de identificaci&oacute;n ingresado no cumple el formato permitido ('+leyendaFormato+')',resp3);
                return false;
            }
            return true
        }
        return true;
        
    }
}
                            
                        




						

