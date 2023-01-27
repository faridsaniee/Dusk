<?php
include_once('include/function.inc.php');
include_once('include/function-template.inc.php');
include_once('include/function-user.inc.php');
include_once('include/function-data.inc.php');
$user = new user();
$is_login = $user->function_return_user_data("login");
$lang = $GLOBALS['global_lang'];
$direction = $GLOBALS['direction'];
$service_name  = "data";
$action = "list";
if(array_key_exists('action',$_GET)){$action = $_GET['action'];}
?>
<!doctype html>
<html class="no-js h-100 <?php echo $service_name; ?> <?php echo $action; ?> lang-<?php echo $lang; ?>" lang="<?php echo $lang; ?>" dir="ltr">
    <?php
    switch ($action)
    {
        case 'new':
            func_data_fen();
            break;
        case 'edit':
            func_data_fen();
            break;
        case 'full':
            func_data_fen();
            break;
        case 'delete':
            func_data_fen();
            break;
        case 'report':
            func_data_report();
            break;
        default:
            func_data_list();
            break;
    }
    function func_data_list(){include_once('data-list.php');}
    function func_data_fen(){include_once('data-fen.php');}
    function func_data_report(){include_once('data-report.php');}
    ?>
</html>