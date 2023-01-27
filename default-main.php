<?php
$user = new user();
$is_login = $user->function_return_user_data("login");
if(!$is_login){$user->function_return_user_data("redirect");}

$lang = $GLOBALS['global_lang'];
$direction = $GLOBALS['direction'];
$service_name = "default";
$action = "main";
$page_title = "Report";

$population_all = 0;
$output_country = "";
$county_data = func_return_population_country();
for ($i=0; $i < count($county_data); $i++)
{ 
    $country_title = $county_data[$i]['country_title'];
    $country_id = $county_data[$i]['country_id'];
    $country_population = $county_data[$i]['population'];
    $population_all += $country_population;
    $output_country .= '<option value="'.$country_id.'">'.$country_title.' ('.$country_population.')</option>';
}


$nav_title = '<i class="fa fa-chart-line me-2"></i>'. $page_title;
$breadcrumb_array = array
(
  array("href"=>"#","title"=>$nav_title),
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
    <div class="container" id="body-min">
        <div class="row my-3">
            <div class="col-md-5 col-11 m-auto p-3 rounded bg-light">
                <form class="noaction">
                    <div class="form-group text-start mb-2" id="box_country">
                        <label for="fld_country">Country:</label>
                        <select class="form-select" id="fld_country">
                            <option value="0">All (<?php echo $population_all?>)</option>
                            <?php echo $output_country?>
                        </select>
                    </div>
                    <div class="form-group text-start mb-2 d-none" id="box_city">
                        <label for="fld_city">City:</label>
                        <select class="form-select" id="fld_city">
                        </select>
                    </div>
                    <div class="form-group text-start mb-2" id="box_type">
                        <label for="fld_password">Type:</label>
                        <select class="form-select" id="fld_type"></select>
                    </div>
                </form>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-5 col-11 m-auto p-3 rounded bg-light d-none" id="box_table">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">#</th>
                                    <th scope="col">Country</th>
                                    <th scope="col">City</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Age Group</th>
                                    <th scope="col">Population</th>
                                </tr>
                            </thead>
                            <tbody id="city_data">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once('include/template/footer.php');?>
    <script type="text/javascript">
        func_set_country_gender(0);
        $( "#fld_country" ).change(function() {
            $("#box_table").addClass("d-none");
            $("#city_data").html("");
            var country_id = $(this).val();        
            if(country_id == 0){$("#box_city").addClass("d-none");}
            else
            {
                func_set_country(country_id);
                $("#box_city").removeClass("d-none");
            }
        });
        $( "#fld_city" ).change(function() {
            var city_id = $(this).val();        
            func_set_city(city_id);
            if(!city_id){$("#box_table").addClass("d-none");}
            else
            {
                func_get_city_detail(city_id);
                $("#box_table").removeClass("d-none");
            }
        });
    </script>
</body>