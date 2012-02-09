<?PHP echo DOCTYPE;?>
<html>

<head>

<title><?PHP echo ucwords(SITE_PRE) . ucwords(PAGE_TITLE);?></title>

<?PHP
// OUTPUT CHARACTER SET
echo CHARSET;

// OUTPUT META DATA
foreach($_metadata as $key=>$value) {
	echo "{$value}\n";
}

// LOAD HEADER INFO BASED ON CONFIG.PHP
misc::load_head();

// LOAD CKEDITOR
if($enable_ckeditor) {
	echo $script_pre.LIB."ckeditor/ckeditor.js".$script_post;
}

// INITIALIZE SECURITY
$security = new form_security();
define("TOKEN",$security->load());
?>

<!-- DETECT BROWSER AND USE ALTERNATE CSS IF NEEDED -->
<!--[if IE]>
	<?PHP echo $style_pre . $_stylesheet['ie'] . $style_post . "\n";?>
<![endif]-->
<!--[if IE 6]>
	<?PHP echo $style_pre . $_stylesheet['ie6'] . $style_post . "\n";?>
<![endif]-->
<!--[if IE 7]>
	<?PHP echo $style_pre . $_stylesheet['ie7'] . $style_post . "\n";?>
<![endif]-->
<!--[if IE 8]>
	<?PHP echo $style_pre . $_stylesheet['ie8'] . $style_post . "\n";?>
<![endif]-->
<!--[if IE 9]>
	<?PHP echo $style_pre . $_stylesheet['ie9'] . $style_post . "\n";?>
<![endif]-->
<!--[if lt IE 9]>
	<script src="lib/js/html5.js"></script>
<![endif]-->
<!-- END ALTERNATE CSS SECTION -->

<?PHP if($enable_js_constants) {?>
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

<!-- 960 PRIMARY CONTAINER -->
<div class="container_16">

<header>
	
</header>