<?php
include_once('config.php');
function func_return_location($parent_id)
{
    $if_str = "";
    if(!empty($parent_id)){$if_str = "WHERE ip_location.parent_id = $parent_id";}
    $sql = '
        SELECT
            ip_location.title as city_title,
            ip_location.id as city_id,
            ip_location_country.title as country_title,
            ip_location_country.id as country_id
        FROM ip_location 
        INNER JOIN ip_location as ip_location_country ON ip_location.parent_id = ip_location_country.id
        '.$if_str.'
    ';
    $conn  = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    mysqli_set_charset($conn,"utf8");
    $qur = mysqli_query($conn, $sql);
    $result = mysqli_fetch_all($qur,MYSQLI_ASSOC);
    mysqli_free_result($qur);
    mysqli_close($conn);
    return $result;
}
function func_add_data($data)
{
    $status = 400;
    $data_id = 0;
    if(!func_check_data_unique($data))
    {
        $data_id = rand(100,999) * time() . rand(100,999);
        $location_id = 0;
        $gender_id = 0;
        $population = 0;
        $age_group = 0;
        $uid = function_return_user_data("uid");
        if(array_key_exists('location_id', $data)){$location_id = $data['location_id'];}
        if(array_key_exists('gender_id', $data)){$gender_id = $data['gender_id'];}
        if(array_key_exists('population', $data)){$population = $data['population'];}
        if(array_key_exists('age_group', $data)){$age_group = $data['age_group'];}
        $sql = "INSERT INTO ip_data 
        (
            `data_id`,
            `location_id`,
            `gender_id`,
            `population`,
            `age_group`,
            `uid`
        ) 
        VALUES 
        (
            '$data_id', 
            '$location_id', 
            '$gender_id',
            '$population', 
            '$age_group',
            '$uid'
        )";
        $conn  = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        mysqli_set_charset($conn,"utf8");
        $qur = mysqli_query($conn,$sql);
        mysqli_close($conn);
        $status = 200;
    }
    $response = array("status" => $status, "data_id" => $data_id);
    return $response;
}
function func_update_data($data)
{

    $data_id = "";
    $population = 0;
    if(array_key_exists('data_id', $data)){$data_id = $data['data_id'];}
    if(array_key_exists('population', $data)){$population = $data['population'];}
    $sql = '
        UPDATE `ip_data`
        SET  `population`= "'.$population.'" WHERE `data_id` = "'.$data_id.'";
        ';
    $conn  = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    mysqli_set_charset($conn,"utf8");
    $qur = mysqli_query($conn,$sql);
    mysqli_close($conn);
    $status = 200;
    return $response;
}
function func_delete_data($data)
{

    $data_id = "";
    if(array_key_exists('data_id', $data)){$data_id = $data['data_id'];}
    $sql = '
        DELETE FROM `ip_data`
        WHERE `data_id` = "'.$data_id.'";
        ';
    $conn  = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    mysqli_set_charset($conn,"utf8");
    $qur = mysqli_query($conn,$sql);
    mysqli_close($conn);
    $status = 200;
    return $response;
}
function func_check_data_unique($data)
{
    $location_id = 0;
    $gender_id = 0;
    $population = 0;
    $age_group = 0;
    if(array_key_exists('location_id', $data)){$location_id = $data['location_id'];}
    if(array_key_exists('gender_id', $data)){$gender_id = $data['gender_id'];}
    if(array_key_exists('population', $data)){$population = $data['population'];}
    if(array_key_exists('age_group', $data)){$age_group = $data['age_group'];}
    $sql = '
        SELECT id
        FROM ip_data
        WHERE 
            ip_data.`location_id` = '.$location_id.' AND
            ip_data.`gender_id` = '.$gender_id.' AND
            ip_data.`age_group` = '.$age_group.'
    ';
    $conn  = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    mysqli_set_charset($conn,"utf8");
    $qur = mysqli_query($conn,$sql);
    $result =  mysqli_fetch_all($qur,MYSQLI_ASSOC);
    $count_row = mysqli_num_rows($qur);
    mysqli_free_result($qur);
    mysqli_close($conn);
    return $count_row;
}
function func_return_data_list($limit,$offset)
{
    $lmt_str = 'limit '.$limit.' OFFSET '.$offset;
    $sql = '
        SELECT
            ip_data.`data_id`,
            ip_data.`location_id` as city_id,
            ip_location.`title` as city_title,
            ip_location_country.`id` as country_id,
            ip_location_country.`title` as country_title,
            ip_data.`gender_id`,
            ip_data.`population`,
            ip_data.`age_group`
        FROM ip_data
        INNER JOIN ip_location ON ip_location.id = ip_data.location_id
        INNER JOIN ip_location as ip_location_country ON ip_location.parent_id = ip_location_country.id
        '.$lmt_str.'
    ';
    $sql_count = 
    '
        SELECT count(ip_data.`data_id`) as count_all
        FROM ip_data
        INNER JOIN ip_location ON ip_location.id = ip_data.location_id
    ';
    $conn  = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    mysqli_set_charset($conn,"utf8");
    $qur = mysqli_query($conn,$sql);
    $qur_count = mysqli_query($conn,$sql_count);
    $result =  mysqli_fetch_all($qur,MYSQLI_ASSOC);
    $result_count = mysqli_fetch_array($qur_count,MYSQLI_ASSOC);
    $count_all = $result_count['count_all'];
    $count_row = mysqli_num_rows($qur);
    mysqli_free_result($qur);
    mysqli_free_result($qur_count);
    mysqli_close($conn);
    $statistics = array("count_all" => $count_all,"count_row" => $count_row);
    $result = array("result" => $result, "statistics" => $statistics);
    return $result;
}
function func_return_data_topcountry($limit,$offset)
{
    $lmt_str = 'limit '.$limit.' OFFSET '.$offset;
    $sql = '
        SELECT * From (
        SELECT
            ip_location_country.`id` as country_id,
            ip_location_country.`title` as country_title,
            SUM(ip_data.`population`) as population
        FROM ip_data
        INNER JOIN ip_location ON ip_location.id = ip_data.location_id
        INNER JOIN ip_location as ip_location_country ON ip_location.parent_id = ip_location_country.id
        GROUP by ip_location_country.id
        limit 3) as data
        ORDER BY population DESC
    ';
    $conn  = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    mysqli_set_charset($conn,"utf8");
    $qur = mysqli_query($conn,$sql);
    $result =  mysqli_fetch_all($qur,MYSQLI_ASSOC);
    mysqli_free_result($qur);
    mysqli_close($conn);
    return $result;
}
function func_return_data_full($data_id)
{
    $sql = '
        SELECT
            ip_data.`data_id`,
            ip_data.`location_id`,
            ip_data.`gender_id`,
            ip_data.`population`,
            ip_data.`age_group`
        FROM ip_data
        INNER JOIN ip_location ON ip_location.id = ip_data.location_id
        WHERE ip_data.`data_id` = '.$data_id.'
    ';
    $conn  = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    mysqli_set_charset($conn,"utf8");
    $qur = mysqli_query($conn,$sql);
    $result =  mysqli_fetch_array($qur,MYSQLI_ASSOC);
    mysqli_free_result($qur);
    mysqli_close($conn);
    return $result;
}
function func_return_population_country()
{
    $sql = '
        SELECT
                ip_location_country.`id` as country_id,
                ip_location_country.`title` as country_title,
                SUM(ip_data.`population`) as population
        FROM ip_data
        INNER JOIN ip_location ON ip_location.id = ip_data.location_id
        INNER JOIN ip_location as ip_location_country ON ip_location.parent_id = ip_location_country.id
        GROUP BY ip_location_country.`id`
    ';
    $conn  = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    mysqli_set_charset($conn,"utf8");
    $qur = mysqli_query($conn,$sql);
    $result =  mysqli_fetch_all($qur,MYSQLI_ASSOC);
    mysqli_free_result($qur);
    mysqli_close($conn);
    return $result;
}
function func_return_population_gender()
{
    $sql = '
        SELECT
                ip_data.`gender_id`,
                SUM(ip_data.`population`) as population
        FROM ip_data
        GROUP BY ip_data.`gender_id`
    ';
    $conn  = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    mysqli_set_charset($conn,"utf8");
    $qur = mysqli_query($conn,$sql);
    $result =  mysqli_fetch_all($qur,MYSQLI_ASSOC);
    mysqli_free_result($qur);
    mysqli_close($conn);
    return $result;
}
function func_return_population_city($country_id = null)
{
    $if_str = "";
    if(!empty($country_id)){$if_str = "WHERE ip_location.parent_id = $country_id";}
    $sql = '
        SELECT
            ip_data.`location_id` as city_id,
            ip_location.`title` as city_title,
            SUM(ip_data.`population`) as population
        FROM ip_data
        INNER JOIN ip_location ON ip_location.id = ip_data.location_id
        INNER JOIN ip_location as ip_location_country ON ip_location.parent_id = ip_location_country.id
        '.$if_str.'
        GROUP by ip_data.`location_id`
    ';
    $conn  = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    mysqli_set_charset($conn,"utf8");
    $qur = mysqli_query($conn,$sql);
    $result =  mysqli_fetch_all($qur,MYSQLI_ASSOC);
    mysqli_free_result($qur);
    mysqli_close($conn);
    return $result;
}
function func_return_population_city_gender($city_id = null)
{
    $if_str = "";
    if(!empty($city_id)){$if_str = "WHERE ip_data.location_id = $city_id";}
    $sql = '
        SELECT
            IF(ip_data.`gender_id` = 1,"Male","Female") as gender_title,
            ip_data.`gender_id`,
            SUM(ip_data.`population`) as population
        FROM ip_data
            '.$if_str.'
            GROUP BY gender_id
    ';
    $conn  = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    mysqli_set_charset($conn,"utf8");
    $qur = mysqli_query($conn,$sql);
    $result =  mysqli_fetch_all($qur,MYSQLI_ASSOC);
    mysqli_free_result($qur);
    mysqli_close($conn);
    return $result;
}
function func_return_population_country_gender($country_id = null)
{
    $if_str = "";
    if(!empty($city_id)){$if_str = "WHERE ip_location.id = $country_id";}
    $sql = '
        SELECT
            IF(ip_data.`gender_id` = 1,"Male","Female") as gender_title,
            ip_data.`gender_id`,
            SUM(ip_data.`population`) as population
        FROM ip_data
        INNER JOIN ip_location ON ip_location.id = ip_data.location_id
            '.$if_str.'
            GROUP BY gender_id
    ';
    $conn  = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    mysqli_set_charset($conn,"utf8");
    $qur = mysqli_query($conn,$sql);
    $result =  mysqli_fetch_all($qur,MYSQLI_ASSOC);
    mysqli_free_result($qur);
    mysqli_close($conn);
    return $result;
}
function func_return_population($city_id)
{
    $if_str = "";
    if(!empty($city_id)){$if_str = "WHERE ip_location.id = $city_id";}
    $sql = '
        SELECT
            ip_data.`location_id` as city_id,
            ip_location.`title` as city_title,
            ip_location_country.`id` as country_id,
            ip_location_country.`title` as country_title,
            ip_data.`gender_id`,
            IF(ip_data.`gender_id` = 1,"Male","Female") as gender_title,
            ip_data.`age_group`,
            SUM(ip_data.`population`) as population
        FROM ip_data
        INNER JOIN ip_location ON ip_location.id = ip_data.location_id
        INNER JOIN ip_location as ip_location_country ON ip_location.parent_id = ip_location_country.id
        '.$if_str.'
        GROUP BY gender_id,age_group
    ';
    $conn  = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    mysqli_set_charset($conn,"utf8");
    $qur = mysqli_query($conn,$sql);
    $result =  mysqli_fetch_all($qur,MYSQLI_ASSOC);
    mysqli_free_result($qur);
    mysqli_close($conn);
    return $result;
}