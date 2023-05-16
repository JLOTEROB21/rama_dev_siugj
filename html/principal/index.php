<?php session_start();
	header("Content-Type:text/html;charset=utf-8");
	
	if(isset($_SESSION["idUsr"]))
	{
		if($_SESSION["idUsr"]!="-1")
		{
			header('Location:../principal/inicio.php');
		}
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Neotrai</title>
<link rel="stylesheet" type="text/css" href="../estilos/estilos.css" media="screen" />
<!--[if IE 8]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE8.css" media="screen" /><![endif]-->
<!--[if IE 7]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE7.css" media="screen" /><![endif]-->
<!--[if IE 6]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE6.css" media="screen" /><![endif]-->
<!--[if IE]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE8.css" media="screen" /><![endif]-->
<link rel="stylesheet" type="text/css" href="../Scripts/ext/resources/css/ext-all.css.cgz"/>
<script type="text/javascript" src="../Scripts/ext/adapter/ext/ext-base.js.jgz"></script>
<script type="text/javascript" src="../Scripts/ext/ext-all.js.jgz"></script>
<script type="text/javascript" src="../Scripts/ext/idioma/ext-lang-es.js"></script>
<script type="text/javascript" src="../Scripts/jquery.min.js"></script>
<script type="text/javascript" src="../Scripts/funcionesAjax.js.jgz"></script>
<script type="text/javascript" src="../Scripts/funcionesGenerales.js"></script>
<link rel="stylesheet" href="../Scripts/fancyBox/fancybox/jquery.fancybox-1.3.4.css"  type="text/css" media="screen" />
<script type="text/javascript" src="../Scripts/fancyBox/fancybox/jquery.fancybox-1.3.4.pack.js"></script>

<script type="text/javascript" src="../Scripts/base64.js"></script>
<script type="text/javascript" src="../principal/Scripts/index.js.php"></script>



<script type="text/javascript" src="../Scripts/funcionesUtiles.js.php"></script>
<link rel="stylesheet" type="text/css" href="../estilos/style.css" media="screen">

<style>
	#left_nav ul li a {
		
		width: 350px;
		font-size: 11px;
		}
</style>

</head>

<body>
<div id="main_container">
	<div id="header">
    	<div id="logo"><a href="home.html"><img src="../principal/images/logoNeotrai.gif" width="313" height="81" alt="" title="" border="0"></a></div>
        
        <div id="menu">
            <ul>                                        
                <li><a class="current" href="index.php" title="">Principal</a></li>
                <!--<li><a href="services.html" title="">services</a></li>
                <li><a href="#" title="">clients</a></li>
                <li><a href="#" title="">testimonials</a></li>-->
               	<li><a href="javascript:ingresarSistema()">Cuenta</a></li>
            </ul>
        </div>
        
    </div>
    
    <div class="green_box">
    	<table>
        <tr>
        	<td width=20></td>
        	<td>
    	<div class="clock">
            <div style="background-color:#FFF">
            <img src="../principal/images/frenteWeb.gif" alt="" title="" width="198" height="174">             
            </div>
        </div>
        	</td>
            
            <td width=10></td>
            <td>
        <div class="text_content" style="width:500px">
        <h1>¿Qué es Neotrai?</h1>
        <p class="green" style="font-size:11px">
        
        Es un modelo construido sobre la plataforma Latis, que es el gestor de procesos más poderoso, lo
        que le brinda una garantía de autonomía, auto-gestión, confianza y flexibilidad tanto para personal
        administrativo como para estudiantes y docentes, su arquitectura es 100% web.<br /><br />
        Con Neotrai encontrará más que un sistema de información, ya que nuestra filosofía de trabajo, está centrada en alcanzar la máxima eficiencia que cada institución puede alcanzar.<br /><br />
        Neotrai permite administrar instituciones de educación básica, media y avanzada, es decir, puede ser implementado desde preescolar hasta posgrados, incluyendo educación profesionalizante, puede administrar un nivel o un conjunto de niveles, así como distintos planteles o grupos de escuelas
        
        </p>
        
        <!--<div class="read_more"><a href="#">read more</a></div>-->
        </div>
        	</td>
        </tr>
        </table>
        
       <!-- <div id="right_nav">
            <ul>                                        
                <li><a href="home.html" title="">Lorem ipsum dolor sit amet cons</a></li>
                <li><a href="services.html" title="">Lorem ipsum dolor sit amet cons</a></li>
                <li><a class="current" href="#" title="">Lorem ipsum dolor sit amet cons</a></li>
                <li><a href="#" title="">Lorem ipsum dolor sit amet cons</a></li>
                <li><a href="contact.html" title="">Lorem ipsum dolor sit amet cons</a></li>
            </ul>
        </div>   -->    
        
    
    </div><!--end of green box-->
    
    <div id="main_content">
    	
        <table>
        	<tr>
            	<td STYLE="vertical-align:TOP">
					<div id="left_content" style="width:380px">
                            <h2>Beneficios</h2>
                            <p>
                            "Es una solución de gran alcance y eficiencia, con el mejor tiempo de
                            implementación" 
                            </p>
                            
                             <div id="left_nav">
                                <ul>                                        
                                    <li><a href="#" title="">Adaptabilidad a todo tipo escuela e institución</a></li>
                                    <li><a href="#" title="">Control escolar, académico y administración totalmente integrado</a></li>
                                    <li><a href="#" title="">Optimización del diseño de carga académica y horarios</a></li>
                                    <li><a href="#" title="">Procesamiento de nómina exacto</a></li>
                                    <li><a href="#" title="">Ejecutivos y plataforma en constante evolución</a></li>
                                    <li><a href="#" title="">100% arquitectura Web</a></li>
                                    <li><a href="#" title="">Kiosco online de consulta</a></li>
                                    <li><a href="#" title="">Ahorro en infraestructura tecnológica</a></li>
                                    <li><a href="#" title="">Atención personalizada</a></li>
                                </ul>
                            </div>
                            
                              
                            
                            
                            
                           
                            
                           
                            
                            <div class="contact_information" style="width:300px">
                            <h4>Mayores informes</h4>
                            <p>
                            <img src="../principal/images/phone_icon.gif" alt="" title="" class="box_img">
                            (01 228) 8163465<br>
                           
                            </p>
                            <br><br>
                            <p>
                            <img src="../principal/images/contact_icon.gif" alt="" title="" class="box_img">
                            ventas@neotrai.grupolatis.net<br>
                            
                            </p>            
                            
                            </div>  
                </td>
                <td width="10">
                </td>
                <td STYLE="vertical-align:TOP">
                		<div id="left_content" style="width:380px;padding: 0px;">
                            <h2>Planes</h2>
                            <p>
                            <br /><br />
                            <img src="../principal/images/planes.png" width="409" height="301" />
                            
                           	<br /><br />
                            El paquete básico considera un programa o nivel (ejemplo: Primaria), si requiere otros
                            niveles,
                            por
                            cada
                            uno
                            deberá
                            incrementar
                            $
                            500
                            (quinientos
                            pesos).
                            La contratación mínima es de 12 meses. Si te interesa comprar la licencia pregunta a tu asesor.
                            
                            </p>
                        </div>
                </td>
            </tr>
        </table>

<br /><br />
    
    <div style=" clear:both;"></div>
    </div><!--end of main content-->
 

     <div id="footer">
     		<div class="footer_links">
                 © 2009 LATIS. All rights Reserved.<br />
        LATIS development, The power of the information
			</div>
          
     	<!--<div class="copyright">
<a href="home.html"><img src="../principal/images/footer_logo.gif" alt="" title="" border="0"></a>
        </div>
    	<div class="footer_links"> 
        <a href="#">About us</a>
         <a href="privacy.html">Privacy policy</a> 
        <a href="contact.html">Contact us </a>
        <a href="http://www.wix.com/start/matrix/?utm_campaign=af_webpagedesign.com.au&amp;experiment_id=Greefies">Create your own free web site</a>

        </div>-->
    
    
    </div>  
 
   

</div> <!--end of main container-->


</body></html>