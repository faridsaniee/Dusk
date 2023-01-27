<?php
$lang = $GLOBALS['global_lang'];
$direction = $GLOBALS['direction'];
$site_name = $GLOBALS['global_title'];
$url = $_SERVER['REQUEST_URI'];
$author = $metatag_array["author"];
$keyword =  $metatag_array["keyword"];
$description = strip_tags($metatag_array["description"]);
$img = $metatag_array["img"];;
$type = $metatag_array["type"];;
$title = $metatag_array["title"];
$application = "";
$generator = "";
$language = "";
$language_iso = "";
$language_code = "";
$coverage = "";
$front_title = "";
$copyright = "";
if(empty($title)){$title = $site_name;}
else($page_title = $site_name ." | ". $title);
?>
<title><?php echo $title; ?></title>
<meta charset="UTF-8">
<meta charset="utf-8">
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="author" content="<?php echo $author; ?>"> 
<meta name="description" content="<?php  echo $description; ?>">
<meta name="application-name" content="<?php echo $application; ?>"> 
<meta name="generator" content="<?php echo $generator; ?>">
<meta name="language" content="<?php echo $language; ?>">
<meta name="fontiran.com:license" content="RRLDG">
<meta http-equiv="content-language" content="<?php echo $language_iso ?>">
<link rel = "schema.DC" href = "http://purl.org/DC/elements/1.0/">
<meta name="msvalidate.01" content="1536F87E2A9AD71E65B8F73D796B4092" />
<meta name="apple-mobile-web-app-status-bar" content="#2f4860" />
<meta name="theme-color" content="#2f4860" />
<meta name="msapplication-TileImage" content="./favicon.png?expire=<?php echo val_header_expire?>">
<meta name="msapplication-TileColor" content="#2f4860">
<meta name="msvalidate.01" content="1536F87E2A9AD71E65B8F73D796B4092" />
