<?php
include_once __DIR__ . '/../function.inc.php';
include_once __DIR__ . '/../function-data.inc.php';
$methode = $_SERVER['REQUEST_METHOD'];
$service = "";
if(array_key_exists("service", $_GET)){$service = $_GET['service'];}
if($methode == "POST"){}
switch ($service) 
{
  case 'country_city':
    func_data_country_city();
    break;
  case 'city_gender':
    func_data_city_gender();
    break;
  case 'country_gender':
    func_data_country_gender();
    break;
  case 'city_detail':
    func_data_city_detail();
    break;
}
function func_data_country_city()
{
    $contents = file_get_contents('php://input'); 
    $user_session = val_user_session;
    $results = json_decode($contents);
    $country_id = $results->{'country_id'};
    $result = func_return_population_city($country_id);
    $user_data_json = json_encode($result);
    print_r($user_data_json);
}
function func_data_city_gender()
{
    $contents = file_get_contents('php://input'); 
    $user_session = val_user_session;
    $results = json_decode($contents);
    $city_id = $results->{'city_id'};
    $result = func_return_population_city_gender($city_id);
    $user_data_json = json_encode($result);
    print_r($user_data_json);
}
function func_data_country_gender()
{
    $contents = file_get_contents('php://input'); 
    $user_session = val_user_session;
    $results = json_decode($contents);
    $country_id = $results->{'country_id'};
    $result = func_return_population_country_gender($country_id);
    $user_data_json = json_encode($result);
    print_r($user_data_json);
}
function func_data_city_detail()
{
    $contents = file_get_contents('php://input'); 
    $user_session = val_user_session;
    $results = json_decode($contents);
    $city_id = $results->{'city_id'};
    $result = func_return_population($city_id);
    $user_data_json = json_encode($result);
    print_r($user_data_json);
}
?>