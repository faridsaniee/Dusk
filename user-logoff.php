<?php
$session_name = val_user_session;
unset($_COOKIE[$session_name]);
setcookie($session_name, '', time() - 3600,"/");
header("Location: user?action=login");
$service_name = "user";
$action = "logoff";
$page_title = "Logoff";
$output = "";
$nav_title = '<i class="fa fa-power-off me-2"></i>'. $page_title;
$breadcrumb_array = array
(
  array("href"=>"#","title"=>$nav_title),
);
$breadcrumb = function_return_breadcrumb($service_name,$action,$breadcrumb_array);
$header = new header();
$header->meta_title = $page_title;
$header->meta_author = $page_title;
$header->meta_type = $service_name;
?>
<head>
	<?php 
    echo $header->metatag();
    include_once('include/template/header.php');
	?>
</head>
<body class="<?php echo $direction; ?> <?php echo $service_name; ?> <?php echo $action; ?>">
    <?php include_once('include/template/menu.php');?>
    <div class="container-fluid bg-pille-fade-2" id="breadcrumb">
        <?php echo $breadcrumb?>
    </div>
    <div class="container d-flex align-items-center" id="body">
    </div>
    <?php include_once('include/template/footer.php');?>
</body>