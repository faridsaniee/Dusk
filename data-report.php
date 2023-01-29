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
$data_list_result = func_return_data_topcountry($limit,$offset);
for ($i=0; $i < count($data_list_result); $i++) 
{ 
    $detail = $data_list_result[$i];
    $population = $detail['population'];
    $country_id = $detail['country_id'];
    $country_title = $detail['country_title'];
    $output .= 
    '
    <tr>
        <th scope="row" class="text-center">'.($i+1).'</th>
        <td>'.$country_title.'</td>
        <td>'.$population.'</td>
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
        <div class="row mt-3">
            <div class="col-md-8 col-11 m-auto p-3 rounded bg-light">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">
                            <i class="fa fa-list-alt"></i>
                            Result 
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">#</th>
                                            <th scope="col">Country</th>
                                            <th scope="col">Population</th>
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