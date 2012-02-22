<?php 
header("Content-type: text/css");
require_once("../classes/class.css.php");

// COLOR SCHEME
$primary = "";
$secondary = "";
$accent = "";
?>
/* HTML 5 PRESETS */
header, section, article, footer, nav, aside {
	display: block;
}
/* END HTML 5 PRESETS */

/* MAIN STYLES */
body {
	font-family: arial;
	font-size: 62.5%;
	color: #5D5D5D;
	overflow: scroll;
}

a:link, a:visited {
	color: #0080ff;
	text-decoration: none;
}

a:hover {
	color: #8000ff;
	text-decoration: none;
}

p {
	font-size: 1.2em;
}

#mask {
	display: none;
	width: 100%;
	height: 100%;
	position: fixed;
	top: 0;
	right: 0;
	z-index: 99;
	overflow-x: auto;
	overflow-y: scroll;
	<?PHP echo css::hex2rgba('#000','0.3','background-color');?>
}

.overlay {
	display: none;
	position: absolute;
	top: 200px;
	z-index: 100;
	overflow: hidden;
	padding: 15px 0;
	background: #FFFFFF;
	<?PHP echo css::gradient('#FFFFFF','#e5e5e5');?>
	<?PHP echo css::border_radius('10px');?>
}

.overlay .close_overlay {
	background-image: url('../images/icons/icon_close_01.png');
	background-size: 32px 32px;
	height: 30px;
	width: 30px;
	z-index: 150;
	position: absolute;
	top: 0px;
	right: 10px;
	cursor: pointer;
}


/* CSS3 STRUCTURES AND USAGE */
/*

//  BORDER RADIUS //
Set the pixels equal to the size of the radius desired.
Larger numbers make more pronounced/rounded borders.
On a square box, set to 50px to make a circle.

	-webkit-border-radius: 2px;
    -moz-border-radius: 2px;
    border-radius: 2px;


// BOX SHADOW //
Gives a shadow to a container.
Usage: {x-offet} {y-offset} {blur} {shadow-color}

	-webkit-box-shadow: 1px 1px 3px #292929;
	-moz-box-shadow: 1px 1px 3px #292929;
	box-shadow: 1px 1px 3px #292929;

Can utilize mulitple shadows for unique effects:

	-webkit-box-shadow: 1px 1px 3px green, -1px -1px blue;
	-moz-box-shadow: 1px 1px 3px green,-1px -1px blue;
	box-shadow: 1px 1px 3px green, -1px -1px blue;


// TEXT SHADOW //
Add shadows to text elements.
Usage: {x-offet} {y-offset} {blur} {shadow-color}

	text-shadow: 0 1px 0 white;

Can be used to outline text as well.

	text-shadow: 0 1px 0 black, 0 -1px 0 black, 1px 0 0 black, -1px 0 0 black;


// TEXT STROKE //
Adds a stroke to the text.
CAUTION: AS OF 12/4/2010, THIS EFFECT IS WEBKIT ONLY!!

	-webkit-text-stroke: 3px black;

	
// BACKGROUND GRADIENT //
Creates a CSS gradient

	background-image: -moz-linear-gradient(100% 100% 90deg, #E5E5E5, #FFFFFF); // Bottom color, Top color
	background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#FFFFFF), to(#E5E5E5)); // Top color, Bottom color
	
	
// MULTIPLE BACKGROUNDS //
Puts 2 or more background images inside a single container
Usage: {image-path} {left-offset} {top-offset} {repeat}

	background: url(image/path.jpg) 0 0 no-repeat, url(image2/path.jpg) 100% 0 no-repeat;


// BACKGROUND SIZE //
Sets the size of the background image.
Usage: {x-size} {y-size}

	background: url(path/to/image.jpg) no-repeat;
	-moz-background-size: 100% 100%;
	-o-background-size: 100% 100%;
	-webkit-background-size: 100% 100%;
	background-size: 100% 100%;

	
// TEXT OVERFLOW //
This property can be used to cut off text that exceeds its container, while still providing a bit of feedback for the user, like an ellipsis.

	-o-text-overflow: ellipsis;
	text-overflow:ellipsis;
	overflow:hidden;
	white-space:nowrap;


// FLEXIBLE BOX MODEL //
The Flexible Box Model, will finally allow us to get away from those mangy floats.
This uses the display: box style to overcome the nead for floats.
EXAMPLE:

<div id="container">
	<div id="main"> Main content here </div>
	<aside> Aside content here </aside>
</div>

#container {
    width: 960px;
    height: 500px; // DEMO SIZE ONLY. NORMALLY CONTENT WILL DICTATE HEIGHT //

    background: #e3e3e3;
    margin: auto;

    display: -moz-box;
    display: -webkit-box;
    display: box;
}

#main {
   background: yellow;
   width: 800px;
}   

aside {
	display: block;
    background: red;
    -moz-box-flex: 1;
    -webkit-box-flex: 1;
    box-flex: 1;
}

*/