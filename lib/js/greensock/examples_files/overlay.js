var overlayContent;

function initOverlay() {
	if (!document.getElementsByTagName){ return; }
	var overlay = document.createElement("div");
	overlay.setAttribute('id','overlay');
	overlay.onclick = function () {hideOverlay(); return false;}
	overlay.style.display = 'none';
	overlay.style.position = 'absolute';
	overlay.style.top = '0';
	overlay.style.left = '0';
	overlay.style.zIndex = '90';
	overlay.style.width = '100%';
	
	var b = document.getElementsByTagName("body").item(0);
	b.insertBefore(overlay, b.firstChild);
}

function showOverlay($contentId) {
	var overlay = document.getElementById('overlay');
	if (overlay == undefined) {
		window.alert("Please wait for the page to finish loading.");
		return;
	}
	overlayContent = document.getElementById($contentId);
	overlayContent.style.position = 'absolute';
	overlayContent.style.zIndex = '500';

	repositionOverlayContent();
	
	var sizeInfo = getSize();
	var scrollY = getScrollY();

	overlay.style.height = (sizeInfo.pageHeight + 'px');
	overlay.style.display = 'block';
	
	overlayContent.style.display = 'block';
	
	selects = document.getElementsByTagName("select");
	for (i = 0; i != selects.length; i++) {
		selects[i].style.visibility = "hidden";
	}
	
	if ($.browser.msie && parseInt($.browser.version)<=7)
		overlay.style.display = 'none';
}

function hideOverlay() {
	var overlay = document.getElementById('overlay');
	overlay.style.display = 'none';
	overlayContent.style.display = 'none';

	selects = document.getElementsByTagName("select");
	for (i = 0; i != selects.length; i++) {
		selects[i].style.visibility = "visible";
	}
}

function repositionOverlayContent() {
	if (overlayContent) {
		var sizeInfo = getSize();
		var scrollY = getScrollY();
		var contentHeight = (overlayContent.style.height == 0) ? 500 : overlayContent.style.height.substr(0, overlayContent.style.height.length - 2);
		var contentWidth = (overlayContent.style.width == 0) ? 650 : overlayContent.style.width.substr(0, overlayContent.style.width.length - 2);
		overlayContent.style.top = (scrollY + ((sizeInfo.windowHeight - 35 - contentHeight) / 2) + 'px');
		overlayContent.style.left = (((sizeInfo.pageWidth - 20 - contentWidth) / 2) + 'px');
	}
}

function getSize() {
	var xScroll, yScroll;
	if (window.innerHeight && window.scrollMaxY) {	
		xScroll = document.body.scrollWidth;
		yScroll = window.innerHeight + window.scrollMaxY;
	} else if (document.body.scrollHeight > document.body.offsetHeight){ // all but Explorer Mac
		xScroll = document.body.scrollWidth;
		yScroll = document.body.scrollHeight;
	} else { // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari
		xScroll = document.body.offsetWidth;
		yScroll = document.body.offsetHeight;
	}
	
	var windowWidth, windowHeight;
	if (self.innerHeight) {	// all except Explorer
		windowWidth = self.innerWidth;
		windowHeight = self.innerHeight;
	} else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
		windowWidth = document.documentElement.clientWidth;
		windowHeight = document.documentElement.clientHeight;
	} else if (document.body) { // other Explorers
		windowWidth = document.body.clientWidth;
		windowHeight = document.body.clientHeight;
	}	
	
	pageHeight = (yScroll < windowHeight) ? pageHeight = windowHeight : pageHeight = yScroll;
	pageWidth = (xScroll < windowWidth) ? pageWidth = windowWidth : pageWidth = xScroll;

	return {pageWidth:pageWidth, pageHeight:pageHeight, windowWidth:windowWidth, windowHeight:windowHeight};
}

function getScrollY(){
	if (self.pageYOffset) {
		return self.pageYOffset;
	} else if (document.documentElement && document.documentElement.scrollTop){	 // Explorer 6 Strict
		return document.documentElement.scrollTop;
	} else if (document.body) {// all other Explorers
		return document.body.scrollTop;
	}
}

function addEvents($onLoad, $onResize) {	
	var oldOnLoad = window.onload;
	var oldOnResize = window.onresize;
	if (typeof window.onload != 'function'){
		window.onload = $onLoad;
	} else {
		window.onload = function(){
			oldOnLoad();
			$onLoad();
		}
	}
	if (typeof window.onresize != 'function'){
		window.onresize = $onResize;
	} else {
		window.onresize = function(){
			oldOnResize();
			$onResize();
		}
	}
}

addEvents(initOverlay, repositionOverlayContent);