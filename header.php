<?PHP 
// CACHING, IF ENABLED & NO GET VARIABLES DETECTED
if($enable['cache'] && !$_GET) {
	// CHECK FOR CACHED PAGE
	$cache_loaded = false;
	if(performance::cache_load(PAGE_TITLE,$_cache_options)) { $cache_loaded = true; exit();}
}

// AUTO-LOAD CLASSES
loader::auto_load(CLASSES.'autoload/');

echo DOCTYPE;
?>
<html>

<head>

<title><?PHP echo ucwords(SITE_PRE) . ucwords(PAGE_TITLE);?></title>

<?PHP
// OUTPUT META DATA
loader::load_meta();

// LOAD HEADER INFO BASED ON CONFIG.PHP
$_SESSION['_header'] = loader::load_head();

// LOAD CKEDITOR
loader::load_ckeditor();

// INITIALIZE SECURITY
$security = new form_security();
define("TOKEN",$security->load());
?>

<!-- DETECT BROWSER AND USE ALTERNATE CSS IF NEEDED -->
<!--[if IE]>
	<?PHP echo "<link rel='stylesheet' type='text/css' href='{$_stylesheet['ie']['all']}' />\n";?>
<![endif]-->
<?PHP if(strpos($_SERVER['HTTP_USER_AGENT'],"MSIE 6")) {?>
<!--[if IE 6]>
	<?PHP echo "<link rel='stylesheet' type='text/css' href='{$_stylesheet['ie']['6']}' />\n";?>
<![endif]-->
<?PHP } if(strpos($_SERVER['HTTP_USER_AGENT'],"MSIE 7")) {?>
<!--[if IE 7]>
	<?PHP echo "<link rel='stylesheet' type='text/css' href='{$_stylesheet['ie']['7']}' />\n";?>
<![endif]-->
<?PHP } if(strpos($_SERVER['HTTP_USER_AGENT'],"MSIE 8")) {?>
<!--[if IE 8]>
	<?PHP echo "<link rel='stylesheet' type='text/css' href='{$_stylesheet['ie']['8']}' />\n";?>
<![endif]-->
<?PHP } if(strpos($_SERVER['HTTP_USER_AGENT'],"MSIE 9")) {?>
<!--[if IE 9]>
	<?PHP echo "<link rel='stylesheet' type='text/css' href='{$_stylesheet['ie']['9']}' />\n";?>
<![endif]-->
<?PHP }?>
<!-- END ALTERNATE CSS SECTION -->

<?PHP if($enable['js_constants']) {?>
<!-- LOAD JS CONSTANTS -->
<script type="text/javascript">
<!--
<?PHP echo $js_constants;?>
// -->
</script>
<?PHP }?>

</head>

<?PHP flush();?>

<body>

<?PHP if($enable['960']) { echo "<div class=\"container_16\"><!-- 960 PRIMARY CONTAINER -->"; }?>
<?PHP if($enable['foundation_grid']) { echo "<div class=\"container\"><!-- FOUNDATION PRIMARY CONTAINER -->\n"; }?>


<header>
	
</header>