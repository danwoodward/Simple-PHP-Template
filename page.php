<?php 
//require_once($_SERVER['DOCUMENT_ROOT'].'/_phptemp/template.php');

// This is the same as require_once but saves the hassle of setting paths.
function __autoload($class_name) {include $class_name . '.php';}


// Initialise template object
$objTemplate = new Template();
// SEO
$objTemplate->setTitle($objTemplate->site_name);
$objTemplate->setDescription("This is the page's meta description.");
// CSS
$objTemplate->setStyle(array('home','forms'));
$objTemplate->setExtraStyle('p.example{color:red;}');
// JavaScript
$objTemplate->setBehaviour(array('jquery'));


$objTemplate->setExtraBehaviour("
$(document).ready(function(){

	//extra page js.
	
}); 
");

// Header HTML file
include($objTemplate->header_file);
?>


<p id="paragraph">Page content goes here</p>




<?php include($objTemplate->footer_file); ?>        