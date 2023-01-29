<?php
$lang = $GLOBALS['global_lang'];
$direction = $GLOBALS['direction'];
$service_name = "data";
$action = "list";
$page_title = "Data List";
$output = '';

$limit = val_conf_list_limit;
$page = '1';
if(array_key_exists('page', $_GET)){$page = $_GET['page'];}
$offset = $limit * ($page -1);
$data_list = func_return_data_list($limit,$offset);
$data_list_result = $data_list['result'];
$count_all = $data_list['statistics']['count_all'];
for ($i=0; $i < count($data_list_result); $i++) 
{ 
    $detail = $data_list_result[$i];
    $data_id = $detail['data_id'];
    $gender_id = $detail['gender_id'];
    $population = $detail['population'];
    $age_group = $detail['age_group'];
    switch ($age_group)
    {
        case '1':
            $age_group_caption = "Child";
            break;
        case '2':
            $age_group_caption = "Young";
            break;
        case '3':
            $age_group_caption = "Old";
            break;
        default:
            $age_group_caption = "";
            break;
    }
    $city_id = $detail['city_id'];
    $city_title = $detail['city_title'];
    $country_id = $detail['country_id'];
    $country_title = $detail['country_title'];
    $gender_caption = "Female";
    $gender_icon = "fa-female";
    if($gender_id){$gender_caption = "Male";$gender_icon = "fa-male";}
    $output .= 
    '
    <tr>
        <th scope="row" class="text-center">'.($i+1).'</th>
        <td>'.$country_title.'</td>
        <td>'.$city_title.'</td>
        <td><i class="fa '.$gender_icon.' me-1"></i> '.$gender_caption.'</td>
        <td>'.$age_group_caption.'</td>
        <td>'.$population.'</td>
        <td class="text-center">
          <a class="btn btn-sm btn-success" href="data?action=full&data_id='.$data_id.'">
            <i class="fas fa-edit me-1"></i>View</a>
          <a class="btn btn-sm btn-danger" href="data?action=delete&data_id='.$data_id.'">
            <i class="fas fa-times me-1"></i>Delete</a>
        </td>
    </tr>
    ';
}

$nav_title = '<i class="fa fa-database me-2"></i>'. $page_title;
$breadcrumb_array = array
(
  array("href"=>"#","title"=>$nav_title),
);
$breadcrumb = function_return_breadcrumb($service_name,$action,$breadcrumb_array);
$header = new header();
$header->meta_title = $page_title;
$header->meta_author = $page_title;
$header->meta_type = $service_name;
?>
<!doctype html>
<head>
<?php 
    echo $header->metatag();
    include_once('include/template/header.php');
?>
</head>
<body class="<?php echo $direction; ?> <?php echo $service_name; ?> <?php echo $action; ?>">
    <?php include_once('include/template/menu.php');?>
    <div class="container-fluid" id="breadcrumb">
        <?php echo $breadcrumb?>
    </div>
    <div class="container" id="body">
        <div class="row my-3">
            <div class="col-md-8 col-11 m-auto p-3 rounded bg-light">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">
                            <i class="fa fa-list-alt"></i>
                            Result
                            <small>[ <?php echo $count_all?> Record(s) ]</small>
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover data_tables">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">#</th>
                                            <th scope="col">Country</th>
                                            <th scope="col">City</th>
                                            <th scope="col">Gender</th>
                                            <th scope="col">Age Group</th>
                                            <th scope="col">Population</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php echo $output?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once('include/template/footer.php');?>
</body>