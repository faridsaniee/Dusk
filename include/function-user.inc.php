<?php
include_once('function.inc.php');
Class user
{
    public $user_session = val_user_session;
    function function_return_user_data($status)
    {
        $session_name = val_user_session;
        $uid = '';
        $is_login = false;
        $register = '';
        $name = '';
        $user_data = array("is_login" => $is_login,"data"=> array());
        if(isset($_COOKIE[$session_name]))
        {
            $user_session = $_COOKIE[$session_name];
            $user_session_object = json_decode($user_session);
            $object = new object_array();
            $user_session_array = $object->func_object_to_array($user_session_object);
            $is_login = true;
            $uid = $user_session_array['uid'];
            $name = "";
            $mobile = "";
            $register = "";
            $legal_code = "";
            $name_first = "";
            if(isset($user_session_array['name'])){$name = $user_session_array['name'];}
            if(isset($user_session_array['mobile'])){$mobile = $user_session_array['mobile'];}
            if(isset($user_session_array['created'])){$register = $user_session_array['created'];}
            if(isset($user_session_array['legal_code'])){$legal_code = $user_session_array['legal_code'];}
            if(isset($user_session_array['name_first'])){$name_first = $user_session_array['name_first'];}
            $user_data = array("is_login" => $is_login,"data"=> $user_session_array);
        }
        $value = '';
        switch ($status)
        {
            case 'login':
                $value = $is_login;
                break;
            case 'uid':
                $value = $uid;
                break;
            case 'legal_code':
                $value = $legal_code;
                break;
            case 'name_first':
                $value = $name_first;
                break;
            case 'mobile':
                $value = $mobile;
                break;
            case 'name':
                $value = $name;
                break;
            case 'register':
                $value = $register;
                break;
            case 'logout':
                unset($_COOKIE[$session_name]);
                setcookie($session_name, '', time() - 3600,"/");
                $value = true;
                break;
            case 'logoff':
                unset($_COOKIE[$session_name]);
                setcookie($session_name, null, time() - 3600,"/");
                $value = true;
                break;
            case 'all':
                $value = $user_data;
                break;
            case 'redirect':
                $page_url = "$_SERVER[REQUEST_SCHEME]://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                $url_redirect = urlencode("$page_url");
                header("Location: user?action=login&redirect=$url_redirect");
                //header("Location: default");
                $value = $user_data;
                break;
            case 'redirect_logoff':
                //unset($_COOKIE[$session_name]);
                setcookie($session_name, null, time() - 3600,"/");
                $value = true;
                header("Location: user?action=login");
                break;
        }
        return $value;
    }
    function func_return_user_login($email,$password)
    {  
        $result = array();
        $sql = '
            SELECT
                ip_user.`name_first`,
                ip_user.`name_last`,
                ip_user.`gender`,
                ip_user.timestamp,
                ip_user.uid,
                ip_user.email
            FROM ip_user
            WHERE ip_user.email = "'.$email.'" AND ip_user.password = "'.$password.'"
        ';
        $conn  = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        mysqli_set_charset($conn,"utf8");
        $qur = mysqli_query($conn, $sql);
        $result = mysqli_fetch_array($qur,MYSQLI_ASSOC);
        mysqli_free_result($qur);
        mysqli_close($conn);
        return $result;
    }
}
?>