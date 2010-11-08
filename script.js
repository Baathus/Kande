var loggedIn = false;

var RecaptchaOptions = {theme: 'white',	tabindex: 2};

function checkLogin() {
	var register = document.getElementById('register');
	if (!loggedIn) {
		grayOut(true);
		register.style.display = 'block';
	} else {
		grayOut(false);
		register.style.display = 'none';			
	}
}

document.onkeydown = function(e) { 
	if (e == null)
		keycode = event.keyCode; 
	else
		keycode = e.which; 
	if (keycode == 27) { 
		grayOut(false);
		register.style.display = 'none';			
	}
};

function grayOut(vis, options) {
	// grayOut(true, {'zindex':'50', 'bgcolor':'#0000FF', 'opacity':'70'});
	var options = options || {}; 
	var zindex = options.zindex || 50;
	var opacity = options.opacity || 40;
	var opaque = (opacity / 100);
	var bgcolor = options.bgcolor || '#000000';
	var dark = document.getElementById('darkLayer');
	if (!dark) {
		var tbody = document.getElementsByTagName("body")[0];
		var tnode = document.createElement('div');
			tnode.style.position='absolute';
			tnode.style.top='0px';
			tnode.style.left='0px';
			tnode.style.overflow='hidden';
			tnode.style.display='none';
			tnode.id='darkLayer';
		tbody.appendChild(tnode);
		dark=document.getElementById('darkLayer');
	}
	if (vis) {
		// Calculate the page width and height 
		if( document.body && ( document.body.scrollWidth || document.body.scrollHeight ) ) {
			var pageWidth = document.body.scrollWidth+'px';
			var pageHeight = document.body.scrollHeight+'px';
		} else if( document.body.offsetWidth ) {
		var pageWidth = document.body.offsetWidth+'px';
		var pageHeight = document.body.offsetHeight+'px';
		} else {
		var pageWidth='100%';
		var pageHeight='100%';
		}   
		//set the shader to cover the entire page and make it visible.
		dark.style.opacity = opaque;                      
		dark.style.MozOpacity = opaque;                   
		dark.style.filter = 'alpha(opacity='+opacity+')'; 
		dark.style.zIndex = zindex;        
		dark.style.backgroundColor = bgcolor;  
		dark.style.width = pageWidth;
		dark.style.height = pageHeight;
		dark.style.display = 'block';
	} else {
		dark.style.display='none';
	}
}

function checkFields() {
	if (!document.getElementById('name').value)
		alert('Du har glemt å skrive inn navn'); // eller snarere, gjør gjeldende felt rødt ellerno
	// osv.
}

function checkTags() {
	// sammenlikn innhold i id="tags" med database av tags
}