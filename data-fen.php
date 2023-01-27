<?php
$lang = $GLOBALS["global_lang"];
$direction = $GLOBALS["global_direction"];
$service_name = "doctor";
$menu_name = "account";
$action = "new";
$data_id = "";
if(array_key_exists('action', $_GET)){$action = $_GET['action'];}
if(array_key_exists('data_id', $_GET)){$data_id = $_GET['data_id'];}
$img_url ="";
$page_title = "Add Data";

$output_city = '';
$fld_population = rand(100,999);
$fld_gender_male_checked = "";
$fld_gender_female_checked = "";
$fld_age_group_child_checked = "";
$fld_age_group_young_checked = "";
$fld_age_group_old_checked = "";
$fld_location_id = "";

if($action == "full" || $action == "edit" || $action == "delete")
{
    $page_title = "View";
    $data_result = func_return_data_full($data_id);
    $fld_location_id = $data_result['location_id'];
    $fld_gender = $data_result['gender_id'];
    $fld_population = $data_result['population'];
    $fld_age_group = $data_result['age_group'];
    switch ($fld_age_group)
    {
        case '1':
            $fld_age_group_child_checked = "checked";
            break;
        case '2':
            $fld_age_group_young_checked = "checked";
            break;
        case '2':
            $fld_age_group_old_checked = "checked";
            break;
    }
    switch ($fld_gender)
    {
        case '1':
            $fld_gender_male_checked = "checked";
            break;
        case '0':
            $fld_gender_female_checked = "checked";
            break;
    }
}

$city_data = func_return_location(null);
$object = new object_array();
$city_group = $object->func_group_array($city_data,"country_id");
$city_group_keys = array_keys($city_group);
for ($i=0; $i < count($city_group); $i++)
{ 
    $city_group_key = $city_group_keys[$i];
    $city_group_detail = $city_group[$city_group_key];
    $country_title = $city_group_detail[0]['country_title'];
    $output_city .= '<optgroup  label="'.$country_title.'">';
    for ($j=0; $j < count($city_group_detail); $j++)
    { 
        $city_title = $city_group_detail[$j]['city_title'];
        $city_id = $city_group_detail[$j]['city_id'];
        $city_selected = "";
        if($city_id == $fld_location_id){$city_selected = "selected";}
        $output_city .= '<option value="'.$city_id.'" '.$city_selected.'>'.$city_title.'</option>';
    }
    $output_city .= '</optgroup>';
}
// 



if($_POST)
{
    $data = array
    (
      "data_id" => $data_id,
      "location_id" => $_POST['fld_city'],
      "gender_id" => $_POST['fld_gender'],
      "age_group" => $_POST['fld_age_groupender'],
      "population" => $_POST['fld_population']
    );
    if($action == "new")
    {
        $response = func_add_data($data);
        $status = $response['status'];
        if($status == 200)
        {
            $data_id = $response['data_id'];
            header("location:data");
        }
        else
        {

        }
    }
    elseif($action == "edit")
    {
        $response = func_update_data($data);
        $status = $response['status'];
        header("location:data?action=full&data_id=$data_id");
    }
    elseif($action == "delete")
    {
        $response = func_delete_data($data);
        $status = $response['status'];
        header("location:data");
    }
}

$nav_title = '<i class="fa-solid fa-user-doctor mx-2"></i>'.$page_title;
$breadcrumb_array = array
(
    array("href"=>"data","title"=> "Data List"),
    array("href"=>"#","title"=>$nav_title)
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
  $meta_img = "";
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
        <div class="row my-3">
            <div class="col-md-8 col-11 m-auto">
                <form class="row m-auto" method="post">
                    <div class="row">
                        <div class="col-6 m-auto mb-4">
                            <label class="form-label d-block small">City: *</label>
                            <select class="form-select" name="fld_city" id="fld_city">
                                <?php echo $output_city?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 m-auto mb-4">
                            <label class="form-label d-block small">Gender: *</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="fld_gender" id="gender_male" value="1" required <?php echo $fld_gender_male_checked?>>
                                <label class="form-check-label" for="gender_male">
                                <i class="fa fa-male me-2"></i>Male
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="fld_gender" id="gender_female" value="0" required <?php echo $fld_gender_female_checked?>>
                                <label class="form-check-label" for="gender_female">
                                    <i class="fa fa-female me-2"></i>Female
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 m-auto mb-4">
                            <label class="form-label d-block small">Age Group: *</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="fld_age_groupender" id="age_child" value="1" required <?php echo $fld_age_group_child_checked?>>
                                <label class="form-check-label" for="age_child">Child</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="fld_age_groupender" id="age_young" value="2" required <?php echo $fld_age_group_young_checked?>>
                                <label class="form-check-label" for="age_young">Young</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="fld_age_groupender" id="age_old" value="3" required <?php echo $fld_age_group_old_checked?>>
                                <label class="form-check-label" for="age_old">Old</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 m-auto mb-4">
                            <label class="form-label d-block small">Population: *</label>
                            <input type="number" pattern="\d*" class="form-control" id="fld_population" name="fld_population" required value="<?php echo $fld_population?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 m-auto text-center">
                            <?php if($action != "delete"){ ?>
                            <button type="submit" class="btn btn-success btn-sm" id="btn_result">
                                Save
                            </button>
                            <?php } ?>
                            <?php if($action == "delete"){ ?>
                            <button type="submit" class="btn btn-danger btn-sm" id="btn_result">
                                DELETE
                            </button>
                            <?php } ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include_once('include/template/footer.php');?>
</body>