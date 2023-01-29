<?php
Class header
{
    public $lang;
    public $url;
	public $direction;
	public $site_name;
	public $author;
	public $keyword;
	public $description;
	public $img;
	public $type;
	public $title;
	public $generator;
	public $language;
	public $language_iso;
	public $language_code;
	public $coverage;
	public $front_title;
	public $copyright;
	public $application;
	public $application_theme_color;
	public $expire;
    function __construct() 
    {
    	$this->url = $_SERVER['REQUEST_URI'];
    	$this->lang = $GLOBALS['global_lang'];
    	$this->direction = $GLOBALS['direction'];
    	$this->site_name = $GLOBALS['global_title'];
    	$this->application = val_application_title;
    	$this->application_theme_color = val_application_theme_color;
    	$this->expire = val_header_expire;
    }
    function metatag()
    {
    	$description = $this->description;
    	if(!empty($description)){$description = strip_tags($description);}
		$title = $this->title;
		if(empty($title)){$title = $this->site_name;}
		else($page_title = $site_name ." | ". $title);
		$heder_output = 
		'
			<title>'.$title.'</title>
			<meta charset="UTF-8">
			<meta charset="utf-8">
			<meta name="apple-mobile-web-app-capable" content="yes" />
			<meta http-equiv="content-type" content="text/html; charset=UTF-8">
			<meta http-equiv="x-ua-compatible" content="ie=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<meta name="author" content="'.$this->author.'"> 
			<meta name="description" content="'.$this->description.'">
			<meta name="application-name" content="'.$this->application.'"> 
			<meta name="generator" content="'.$this->generator.'">
			<meta name="language" content="'.$this->language.'">
			<meta name="fontiran.com:license" content="RRLDG">
			<meta http-equiv="content-language" content="'.$this->language_iso.'">
			<link rel = "schema.DC" href = "http://purl.org/DC/elements/1.0/">
			<meta name="apple-mobile-web-app-status-bar" content="'.$this->application_theme_color.'" />
			<meta name="theme-color" content="'.$this->application_theme_color.'" />
			<meta name="msapplication-TileImage" content="./favicon.png?expire='.$this->expire.'>">
			<meta name="msapplication-TileColor" content="'.$this->application_theme_color.'">
			<meta name="msvalidate.01" content="1536F87E2A9AD71E65B8F73D796B4092" />

		';
		return $heder_output;
    }
}
?>
