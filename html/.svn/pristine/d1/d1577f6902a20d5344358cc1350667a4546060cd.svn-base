WPopup=function(caption,url,height,width,callback_fn,funcionEjecutar)
{
	//document.tutores.Parentezco_Itu.visible=false;
    var options=    {
                        caption:caption,
                        height: height || 500,
                        width: width || 500,
                        fullscreen: false,
                        overlay_click_close: true,
                        show_loading: true,
                        callback_fn: callback_fn,
						scroll:0,
                        onHide:function()
                        {
                           funcionEjecutar();
                        }
                    }
          
    var ventana=new GB_Window(options);
	return ventana.show(url);
}