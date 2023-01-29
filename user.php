<?php
include_once('include/function.inc.php');
include_once('include/function-template.inc.php');
include_once('include/function-user.inc.php');
include_once('include/header.inc.php');

$user = new user();
$is_login = $user->function_return_user_data("login");
$service_name = "user";
$action = "";
$redirect = "default";
if(array_key_exists('action',$_GET)){$action = $_GET['action'];}
if(array_key_exists('redirect',$_GET)){$redirect = $_GET['redirect'];}
if($is_login)
{
    $uid = $user->function_return_user_data("uid");
    if($action == "login"){header("Location: $redirect");}
}
else
{
  //$action = "login";
}
?>
<!doctype html>
<html class="no-js h-100 <?php echo $service_name; ?> <?php echo $action; ?> lang-<?php echo $lang; ?>" lang="<?php echo $lang; ?>" dir="ltr">
<?php
    switch ($action) 
    {
      case 'login':
        func_user_login();
        break;
      case 'logoff':
        func_user_logoff();
        break;
      default:
        func_user_login();
        break;
    }
    function func_user_login(){include_once('user-login.php');}
    function func_user_logoff(){include_once('user-logoff.php');}
?>
</html>