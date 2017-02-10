/**
 * @author Luiz Caramez
*/
function opacity(id, opacStart, opacEnd, millisec) { 
    //speed for each frame 
	this.object = document.getElementById(id);
    this.speed = Math.round(millisec / 100); 
    this.timer = 0; 
	this.initialClassName = this.object.className;
	
	this.object.className = this.object.className + ' ' + 'lastInsertedRow';
    //determine the direction for the blending, if start and end are the same nothing happens 
    if(opacStart > opacEnd) { 
        for(i = opacStart; i >= opacEnd; i--) { 
            this.setTimeout("changeOpac(" + i + ",'" + id + "')",(this.timer * this.speed)); 
            timer++; 
        }
		
    } else if(opacStart < opacEnd) { 
        for(i = opacStart; i <= opacEnd; i++) 
            { 
            this.setTimeout("changeOpac(" + i + ",'" + id + "')",(this.timer * this.speed)); 
            timer++; 
        }
		
    } 
//	this.object.className = this.initialClassName;
} 

//change the opacity for different browsers 
function changeOpac(opacity, id) { 
    this.object = document.getElementById(id).style; 
    this.object.opacity = (opacity / 100); 
    this.object.MozOpacity = (opacity / 100); 
    this.object.KhtmlOpacity = (opacity / 100);
	
	var arVersion = navigator.appVersion.split("MSIE");
	var version = parseFloat(arVersion[1]);

	if ((version >= 5.5) && (document.body.filters) && opacity == 100) {  
    	this.object.filter = "";
	} else {
		this.object.filter = "alpha(opacity=" + opacity + ")";
	}	
}


/* Script de: http://www.quirksmode.org/
 * 
 */
var menu; var theTop = 70; var old = theTop;
function movemenu() {
  if (window.innerHeight) {
    pos = window.pageYOffset
  }
  else if (document.documentElement && document.documentElement.scrollTop) {
    pos = document.documentElement.scrollTop
  }
  else if (document.body) {
    pos = document.body.scrollTop
  }

  if (pos < theTop) pos = theTop;
  else pos += 0;

  if (pos == old) {
    menu.style.top = pos;
  }

  old = pos;
  temp = setTimeout('movemenu()',100);
}

function setMenuOffset() {
	var header = document.getElementById('sectionInfo');
	if (!header) return;
		var currentOffset = document.documentElement.scrollTop || document.body.scrollTop; // body for Safari
		var startPos = parseInt(setMenuOffset.initialPos) || 67;
		var desiredOffset = startPos - currentOffset;
		if (desiredOffset < 1)
			desiredOffset = 0;
		if (desiredOffset != parseInt(header.style.top))
			header.style.top = desiredOffset + 'px';
		var currentLeftOffset = document.documentElement.scrollLeft || document.body.scrollLeft; // body for Safari
		if (currentLeftOffset != - parseInt(header.style.left))
			header.style.left = '-' + currentLeftOffset + 'px';
}

function getStyle(el,styleProp) {
	var x = document.getElementById(el);
	if (x.currentStyle)
		var y = x.currentStyle[styleProp];
	else if (window.getComputedStyle)
		var y = document.defaultView.getComputedStyle(x,null).getPropertyValue(styleProp);

	return y;
}


/*
 * Funco para load das paginas
 */

window.onload = function () {
	if(document.getElementById('sectionInfo')) {
		setMenuOffset.initialPos = getStyle('sectionInfo','top');
		window.onscroll = document.documentElement.onscroll = setMenuOffset;
		setMenuOffset();
	}
}

