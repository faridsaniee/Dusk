<?php
include_once('include/function.inc.php');
include_once('include/function-user.inc.php');
include_once('include/function-template.inc.php');
include_once('include/function-data.inc.php');
$user = new user();
$is_login = $user->function_return_user_data("login");
$lang = $GLOBALS['global_lang'];
$direction = $GLOBALS['direction'];
$service_name  = "default";
$action = val_default;
if(array_key_exists('action',$_GET)){$action = $_GET['action'];}
?>
<!doctype html>
<html class="no-js h-100 <?php echo $service_name; ?> <?php echo $action; ?> lang-<?php echo $lang; ?>" lang="<?php echo $lang; ?>" dir="ltr">
    <?php
    function_default_print_main();
    function function_default_print_main(){include_once('default-main.php');}
    ?>
</html>