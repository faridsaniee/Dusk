<?php
date_default_timezone_set('Australia/Melbourne');
define("val_conf_list_limit", 20);
define("val_site_session", "dusk_panel");
define("val_user_session", "dusk_user");
define("val_platform_id", 1);
define("val_default_lang", "en");
define("val_header_expire", time()+46000);
define("val_lang_section", "care");
define("val_lang_mode", "json");
define("val_default", "care");
define("DB_HOST", "localhost");
define("DB_NAME", "dusk");
define("DB_USER", "root");
define("DB_PASS", "Salam@22957373");
define("val_conf_debugview", 1);
error_reporting(E_ALL);
ini_set('display_errors', val_conf_debugview);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET');  
header('Cache-Control: max-age = 864000');
header('Vary: Accept-Encoding');
header('Expires:' . gmdate ('D, d M Y H:i:s', time() + "864000") . ' GMT');
?>