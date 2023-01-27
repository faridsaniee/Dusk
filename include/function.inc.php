<?php
include_once('config.php');
$lang = val_default_lang;
if(isset($_COOKIE[val_site_session])){$lang = json_decode($_COOKIE[val_site_session])->language;}
$direction = "ltr";
$title = "Dusk";

$site_data = array("title" => $title,"language" => $lang, "language_id" => "", "direction" => $direction);
if(!isset($_COOKIE[val_site_session])){}
{
    $_COOKIE[val_site_session] = $site_data;
    setcookie(val_site_session, json_encode($site_data), time()+3600);
}
$GLOBALS["global_lang"] = $lang;
$GLOBALS["global_direction"]= $direction;
$GLOBALS["global_title"]= $title;

Class object_array
{
    function func_object_to_array($obj) 
    {
        if(is_object($obj)) $obj = (array) $obj;
        if(is_array($obj)) 
        {
            $new = array();
            foreach($obj as $key => $val)
            {
                $new[$key] = $this->func_object_to_array($val);
            }
        }
        else $new = $obj;
        return $new;       
    }
    function func_group_array($array, $key) 
    {
        $return = array();
        foreach($array as $val) {
            $return[$val[$key]][] = $val;
        }
        return $return;
    }
}
