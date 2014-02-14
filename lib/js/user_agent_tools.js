function detect_agents() {
	var ua = navigator.userAgent;
	var uaClasses = [];
	
	// CHECK FOR OS
	if(ua.indexOf('Windows') >= 0) { uaClasses.push('windows'); }
	if(ua.indexOf('Windows NT 5.0') >= 0) { uaClasses.push('windows-2000'); }
	if(ua.indexOf('Windows NT 5.1') >= 0) { uaClasses.push('windows-xp'); }
	if(ua.indexOf('Windows NT 5.2') >= 0) { uaClasses.push('windows-server-2003'); }
	if(ua.indexOf('Windows NT 6.0') >= 0) { uaClasses.push('windows-vista'); }
	if(ua.indexOf('Windows NT 6.1') >= 0) { uaClasses.push('windows-7'); }
	if(ua.indexOf('Windows NT 6.2') >= 0) { uaClasses.push('windows-8'); }
	if(ua.indexOf('Windows NT 6.3') >= 0) { uaClasses.push('windows-8.1'); }
	if(ua.indexOf('Mac') >= 0) { uaClasses.push('mac'); }
	if(ua.indexOf('Linux') >= 0) { uaClasses.push('linux'); }
	
	// CHECK FOR DEVICE
	if(ua.indexOf('iPad') >= 0) { uaClasses.push('ipad'); }
	if(ua.indexOf('iPhone') >= 0) { uaClasses.push('iphone'); }
	if(ua.indexOf('Android') >= 0) { uaClasses.push('android'); }
	if(ua.indexOf('BlackBerry') >= 0) { uaClasses.push('blackberry'); }
	if(ua.indexOf('Mobile') >= 0) { uaClasses.push('mobile'); }
	if(ua.indexOf('Tablet') >= 0) { uaClasses.push('tablet'); }
	if(ua.indexOf('Phone') >= 0) { uaClasses.push('phone'); }
	
	// CHECK FOR 
	
	// ADD CLASSES TO HTML
	var html = document.getElementsByTagName('html')[0];
	for(var i=0;i<uaClasses.length;i++) {
		html.className += ' '+uaClasses[i];
		//document.write(uaClasses[i]+'<br />');
	}
}

detect_agents();