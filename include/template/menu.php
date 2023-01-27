<?php
$lang = $GLOBALS['global_lang'];
$direction = $GLOBALS['direction'];
$user = new user();
$is_login = $user->function_return_user_data("login");
?>
<div class="container-fluid bg-white" id="menu">
    <div class="">
        <div class="row">
            <div class="col-md-5 col-12 text-center">
                <div id="logo" class="text-start">
                    <a href="default"><img class="h-100 m-auto" src="images/logo.jpg" /></a> 
                </div>
            </div>
            <div class="col-md-7 col-12 m-auto">
                <div class="navbar-collapse navbar navbar-expand text-end float-end">
                    <ul class="navbar-nav">
                        <?php if($is_login){ ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-secondary small" href="#" id="navbar_profile" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user ms-2"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-left" aria-labelledby="navbar_profile">
                                <li>
                                    <a class="dropdown-item small" href="user?action=profile">
                                        <i class="fa fa-user me-2"></i>Profile
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item small text-danger" href="user?action=logoff">
                                        <i class="fa fa-power-off me-2"></i>Logoff
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php }?>
                        <?php if(!$is_login){ ?>
                        <li class="nav-item">
                            <a class="nav-link small text-center text-secondary " href="user?action=login" aria-expanded="false">
                                <i class="fa fa-user ms-2"></i>
                            </a>
                        </li>
                        <?php } ?>
                        <li class="nav-item">
                            <a class="nav-link small text-center text-secondary " href="data?action=report" aria-expanded="false">
                                <i class="fa fa-globe me-2"></i>Top Country
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-secondary small" href="#" id="navbar_data" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-database me-2"></i>Data Management
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbar_data">
                                <li>
                                    <a class="dropdown-item text-start" href="data">
                                        <i class="fa fa-list me-2"></i>View All
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-start" href="data?action=new">
                                        <i class="fa fa-plus me-2"></i>Add New
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div> 
            </div>
        </div>
    </div>
</div>