<?php
include_once __DIR__ . '/../function.inc.php';
include_once __DIR__ . '/../function-user.inc.php';
$methode = $_SERVER['REQUEST_METHOD'];
$service = "";
if(array_key_exists("service", $_GET)){$service = $_GET['service'];}
if($methode == "POST"){}
switch ($service) 
{
  case 'login':
    func_user_login();
    break;
}
function func_user_login()
{
    $contents = file_get_contents('php://input'); 
    $user_session = val_user_session;
    $results = json_decode($contents);
    $email = $results->{'email'};
    $password = $results->{'password'};
    $user = new user();
    $login_result = $user->func_return_user_login($email,$password);
    $status = 404;
    $user_data = array();
    if(is_array($login_result))
    {
        $user_data = array(
          "uid" => $login_result['uid'],
          "name_first" => $login_result['name_first'],
          "name_last" => $login_result['name_last'],
          "gender" => $login_result['gender'],
          "timestamp" => $login_result['timestamp'],
          "email" => $email
        );
        $status = 200;
        setcookie("$user_session", json_encode($user_data),time() + (86400 * 30), "/");
    }
    $user_data = array("status" => $status, "data" => $user_data);
    $user_data_json = json_encode($user_data);
    print_r($user_data_json);
}
?>