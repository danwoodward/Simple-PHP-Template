<?php
 /*
  ===================================================================================
  
  Template Class

    

  Original Code: Phil Thompson hello@philthompson.co.uk 
  
  ===================================================================================
  
  Contents:
  -----------------------------------------------------------------------------------
  
  Variables
  
  Constructor
  
  Methods
  
  	SEO
		setTitle
		setMetaDescription
		setRobots
	CSS
		setStyle
		setExtraStyle
		JavaScript
		setBehaviour
		setExtraBehaviour
	Misc
		setCharset
		setLang
  
  ===================================================================================
 
 */
 
 class Template{
 
 
 	/* Variables */
	
	public $header_file;
	public $footer_file;
	public $site_name;
	public $description;
	public $style;
	public $extra_style;
	public $behaviour;
	public $extra_behaviour;
	public $robots;
	public $charset;
	public $language;
	
	/* Constructor */
	public function __construct(){
	
		$this->site_name = 'Amazing website';
		
		// HTML
		$this->setHeaderFile();
		$this->setFooterFile();
		
		// SEO
		$this->setTitle();
		$this->setDescription();
		$this->setRobots();
		// CSS
		$this->setStyle();
		$this->setExtraStyle();
		// JavaScript
		$this->setBehaviour();
		$this->setExtraBehaviour();
		// Misc
		$this->setCharset();
		$this->setLanguage();
		
		 // id attribute for body tag used for user stylesheets/CSS
		$this->body_id = str_replace('.','-',$_SERVER['HTTP_HOST']);
		
	
	}
	
	
	
	/* Methods */
	
	// setHeaderFile
	public function setHeaderFile(){
		$this->header_file = $_SERVER['DOCUMENT_ROOT'].'/_phptemplate/templates/header.php';
	}
	
	// setFooterFile
	public function setFooterFile(){
		$this->footer_file = $_SERVER['DOCUMENT_ROOT'].'/_phptemplate/templates/footer.php';
	}
	
	// setTitle
	public function setTitle($value = false){
		// this value is ***so*** important for SEO
		$this->title = ($value) ? $value : $this->site_name;
	}
	
	// setDescription
	public function setDescription($value = false){	
		// set a META description (used as site description in Google) if it  has been set on the view page		
		$this->description = ($value) ? '<meta name="description" content="'.$value.'" />'."\n" : '';
	}	
	
	// setRobots
	public function setRobots($value = false){
		// should a page be indexed or not?
		$robots_value = (!$value) ? 'index,follow' : $value;
		$this->robots = '<meta name="robots" content="'.$robots_value.'" />'."\n";
	}
	
	// setStyle
	public function setStyle($value = array()){
	
		$value = (!$value) ? array() : $value;
		
		$this->style_folder = '/style/';
		
		// include default CSS that all pages must have			
		array_unshift($value, "reset", "global");
		
		
		if(is_array($value)){
			
			$this->style = '<style type="text/css" media="all">'."\n";
			
			// loop through items
			foreach($value as $item){
				// script is external (CDN) e.g. begins with http or https
				if(strpos($item,'http') !== false){
					$this->style .= "\t".'@import url("'.$item.'");'."\n";
				}
				// script is local
				else{
					$this->style .= "\t".'@import url("'.$this->style_folder.$item.'.css");'."\n";
				}
			}
			
			$this->style .= '</style>'."\n";
		}
		
		// IE7 fixes
		$this->style .= '<!--[if IE 7]><link rel="stylesheet" type="text/css" href="'.$this->style_folder.'ie7.css" media="all"><![endif]-->'."\n";
		// IE6 fixes
		$this->style .= '<!--[if lt IE 7]><link rel="stylesheet" type="text/css" href="'.$this->style_folder.'ie6.css" media="all"><![endif]-->'."\n";
		
		/*
			SUGGESTED IMPROVEMENTS:
			The CSS could be minified and/or chained together on the fly on the live server
			to increase server performance and user experience
		*/
		
	}
	
	// setExtraStyle
	public function setExtraStyle($value = false){
		// on page CSS - CSS is 100% specific to this individual page and doesn't 
		// warrant its own external stylesheet or to be in the global CSS
		
		// value exists
		if($value){
			// create HTML
			$this->extra_style = '<style type="text/css" media="all">'."\n";
			$this->extra_style .= "\t".$value."\n";
			$this->extra_style .= '</style>'."\n";
		}
		// no value // no extra style
		else{
			$this->extra_style .= '';
		}
		
		// append extra style (if any) to the end
		$this->style .= $this->extra_style;
	}
	
	// setBehaviour
	public function setBehaviour($value = false){
		// JavaScript of page: include at bottom of page in footer (just before </body> tag )
		// should be an array of 0 to many scripts
		
		// include default JavaScript that all pages must have			
		//array_unshift($value, "jquery");
	
		$this->behaviour = '';
		
		if($value){
			if(is_array($value)){
				// loop through items
				foreach($value as $item){
					// script is external (CDN) e.g. begins with http or https
					if(strpos($item,'http') !== false){
						$this->behaviour .= '<script type="text/javascript" src="'.$item.'"></script>'."\n";
					}
					// script is local
					else{
						$this->behaviour .= '<script type="text/javascript" src="/behaviour/'.$item.'.js"></script>'."\n";
					}
				}
			}
		}
		
		
		/*
			SUGGESTED IMPROVEMENTS:
			The JavaScript could be minified and/or chained together on the fly on the live server
			to increase server performance and user experience
		*/
	
	}
	
	// setExtraBehaviour
	public function setExtraBehaviour($value = false){
		// on page JavaScript - this must be 100% specific to this individual page
		if($value){
			$this->extra_behaviour = '<script type="text/javascript">'."\n";
			$this->extra_behaviour .= "\t".$value."\n";
			$this->extra_behaviour .= '</script>'."\n";
		}
		// no value: no extra behaviour
		else{
			$this->extra_behaviour = '';
		}
		
		// now add extra behaviour (if it exists) to the value
		// for extra behaviour to work it has to go underneath 
		// because it may be reliant upon scripts called in setBehaviour
		$this->behaviour .= $this->extra_behaviour;
	}
	
	
	// setCharset
	public function setCharset(){
		// set the character set for the page: 
		// should be different (from default 'utf-8')  if the language is different
		$charset_code = 'utf-8';
		$this->charset = '<meta http-equiv="Content-Type" content="text/html; charset='.$charset_code.'" />'."\n";
	}
	
	// setLang
	public function setLanguage(){
		// set the page language for the page: 		
		$language_code = 'en';
		
		$this->language  = ' lang="'.$language_code.'"';
	}

 
 }

?>