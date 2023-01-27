<?php
$lang = $GLOBALS['global_lang'];
$direction = $GLOBALS['direction'];
$is_login = function_return_user_data("login");
$methode = $_SERVER['REQUEST_METHOD'];
$service_name = "user";
$action = "login";
$ip = $_SERVER['REMOTE_ADDR'];
$methode = $_SERVER['REQUEST_METHOD'];
$img_url ="";
$page_title = "Login";
$redirect = "default";
if(isset($_GET['redirect'])){$redirect = $_GET['redirect'];}

$nav_title = '<i class="fa fa-lock-open me-2"></i> '. $page_title;
$breadcrumb_array = array
(
  array("href"=>"#","title"=>$nav_title),
);
$breadcrumb = function_return_breadcrumb($service_name,$action,$breadcrumb_array);
?>
<!doctype html>
<head>
<?php 
  $meta_title = $page_title;
  $meta_author  = $page_title;
  $meta_description = "";
  $meta_lang = $lang;
  $meta_keyword = "";
  $meta_img = $img_url;
  $meta_type = $service_name;
  $metatag_array= array("lang" => $meta_lang, "title" =>$meta_title, "author"=>$meta_author, "keyword" => $meta_keyword, "description" => $meta_description, "img" => $meta_img, "type" => $meta_type);
  include_once('include/template/metatag.php');
  include_once('include/template/header.php');
?>
</head>
<body class="<?php echo $direction; ?> <?php echo $service_name; ?> <?php echo $action; ?>">
    <?php include_once('include/template/preloader.php');?>
    <?php include_once('include/template/menu.php');?>
    <div class="container-fluid" id="breadcrumb">
        <?php echo $breadcrumb?>
    </div>
    <div class="container" id="body">
        <div class="row mt-3" >
            <div class="col-md-4 col-11 m-auto p-3 rounded">
                <form class="noaction">
                    <div class="form-group text-start mb-2">
                        <label for="fld_email">Email:</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="fld_email_prefix">
                                <i class="fa fa-at"></i>
                            </span>
                            <input type="email"  pattern="[^@\s]+@[^@\s]+\.[^@\s]+" class="form-control ltr text-center" id="fld_email" value=""  aria-describedby="fld_email_prefix" aria-label="fld_email_prefix">
                        </div>
                    </div>
                    <div class="form-group text-start mb-2">
                        <label for="fld_password">Password:</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="fld_password_password">
                                <i class="fa fa-key"></i>
                            </span>
                            <input type="password" class="form-control ltr text-center" id="fld_password" value=""  aria-describedby="fld_password_password" aria-label="fld_password_password">
                        </div>
                    </div>
                    <div class="form-group text-center mt-3">
                        <button type="submit" class="btn btn-success btn-sm" id="btn_login">
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include_once('include/template/footer.php');?>
</body>