        var browser = navigator.appName.substring(0,9);
	var DOM = (document.getElementById) ? 1 : 0;
        var NS4 = (document.layers) ? 1 : 0;
        var IE4 = (document.all) ? 1 : 0;
        var ver4 = (NS4 || IE4) ? 1 : 0;

		//LAS MIAS
function disable_right_click(e)
{
	var browser = navigator.appName.substring ( 0, 9 );
	var event_number = 0;
	var forbidden=false;
	if (browser=="Microsoft" && !DOM)
	{
		event_number = event.button;
		if ( event_number==2 || event_number==3 )
		{
			forbidden=true
		}
	}
	else if (browser=="Netscape")
		{
			if (DOM)
			{
				document.oncontextmenu = function(){;return false}	
				event_number=e.button
				if ( event_number==1 || event_number==2 )
				{
					forbidden=true
				}
			}else
			{
				event_number = e.which;
				if ( event_number==2 || event_number==3 )
				{
					forbidden=true
				}
			};
		}
	else if (browser=="Microsoft" && DOM)
	  {
	    document.oncontextmenu = function(){;return false}	
//	    event_number=e.button
	    if ( event_number==1 || event_number==2 )
	      {
		forbidden=true
	      }
	  }
	else if (browser=="Opera")
	  {
				event_number = e.button;
				if ( event_number==2 || event_number==3 )
				{
					forbidden=true
				}

	  };
	if (forbidden)
	{
		//alert ("Por motivos de seguridad no se permite acceso al menú contextual");
		if (document.URL.indexOf('tools.php')==-1)
		{
		  // abrir('tools.php?title=S@RH','about',(ancho/1.5),(alto/1.5),false);
		}else
		{
		  // alert( navigator.appName)
		}
		return false;
	}else
	{
		return true;
	};
}

function check_mousekey_ie ()
{
	var mouse_key = 93;
	var alt_key = 18;
	var control_key = 17;
	var escape_key = 27;
	var keycode = event.keyCode;
	if ( keycode == mouse_key || keycode == alt_key /*|| keycode == control_key*/ || keycode==escape_key)
	{
			if (document.URL.indexOf('tools.php')==-1)
		{
		  // abrir('tools.php?title=S@RH','about',(ancho/1.5),(alto/1.5),false);
		}else
		{
		  //alert( navigator.appName)
		}
			return false;
	};
}

function check_mousekey_nn (e)
{
	var mouse_key = 93;
	var keycode = e.which;
	var alt_key = 18;
	var control_key = 17;
	if ( keycode == mouse_key || keycode == alt_key || keycode == control_key)
	{
		if (document.URL.indexOf('tools.php')==-1)
		{
		  //abrir('tools.php?title=S@RH','about',(ancho/1.5),(alto/1.5),false);
		}else
		{
		  //alert( navigator.appName)
		}
				return false;
	}
	return true;
}

function check_mousekey_dom (e)
{
	var mouse_key = 93;
	var keycode = e.keyCode;
	var alt_key = 18;
	var control_key = 17;
	if ( keycode == mouse_key || keycode == alt_key /*|| keycode == control_key*/)
	{
		if (document.URL.indexOf('tools.php')==-1)
		{
		  //abrir('tools.php?title=S@RH','about',(ancho/1.5),(alto/1.5),false);
		}else
		{
		  //alert( navigator.appName)
		}
				return false;
	}
	return true;
}


function trap_page_mouse_key_events ()
{
	var browser = navigator.appName.substring ( 0, 9 );
	document.onmousedown = disable_right_click;

	if ( browser == "Microsoft" )
		document.onkeydown = check_mousekey_ie;
	else if ( browser == "Netscape" )
	{
		if (DOM)
		{
			document.onkeydown = check_mousekey_dom;
		}else
		{
			document.captureEvents( Event.MOUSEDOWN );
			document.captureEvents( Event.KEYDOWN );
			document.onKeyDown = check_mousekey_nn;
		}
	}
}

window.onload = trap_page_mouse_key_events;
