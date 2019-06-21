<!DOCTYPE html>
<?php
$userProfilePhoto = Session()->get('ProfilePhoto');
 $action = Route::currentRouteName(); 
use App\Infrastructure\Constants;
?>
<html lang="en" ng-app="myApp" > 
    <head>

        <meta charset="utf-8" />    
        <title> @yield('title','Home') | {{config('app.projectName')}}</title>

        <!--  Set here External CSS -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet">

        <link href="{{ URL::asset('resources/assets/admin/css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ URL::asset('resources/assets/admin/css/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ URL::asset('resources/assets/admin/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ URL::asset('resources/assets/admin/css/uniform.default.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ URL::asset('resources/assets/admin/css/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css"/>


        <link href="{{ URL::asset('resources/assets/admin/css/components.css') }}" id="style_components" rel="stylesheet" type="text/css"/>
        <link href="{{ URL::asset('resources/assets/admin/css/plugins.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ URL::asset('resources/assets/admin/css/layout.css') }}" rel="stylesheet" type="text/css"/>
        <link id="style_color" href="{{ URL::asset('resources/assets/admin/css/darkblue.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ URL::asset('resources/assets/admin/css/custom.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ URL::asset('resources/assets/admin/css/devloper.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ URL::asset('resources/assets/admin/css/toastr.css')}}" rel="stylesheet">
        <link rel="stylesheet" href="{{ URL::asset('resources/assets/admin/css/customcss.css')}}">
        @yield('css')

        <script src="{{ URL::asset('resources/assets/admin/js/jquery.min.js') }}" type="text/javascript"></script>
        
        <script type="text/javascript">window.baseUrl = "<?php echo URL::to('/') ?>";</script>
        <script type="text/javascript">window.basePath = "<?php echo base_path(); ?>";</script>
        <script src="{{ URL::asset('resources/assets/admin/js/angularjs/angular.js')}}"></script>
        <script src="{{ URL::asset('resources/assets/admin/js/angularjs/app.js')}}"></script>


        <!--  Set here External JS -->


        
        <script src="{{ URL::asset('resources/assets/admin/js/jquery.validate.min.js') }}" type="text/javascript"></script>
        <script src="{{URL::asset('resources/assets/admin/js/angularjs/dirPagination.js')}}"></script>

        <script type="text/javascript" src="<?php echo asset('resources/assets/admin/js/angularjs/angular-loading-spinner.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo asset('resources/assets/admin/js/angularjs/angular-spinner.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo asset('resources/assets/admin/js/angularjs/spin.js'); ?>"></script>
        <script type="text/javascript" src="{{ URL::asset('resources/assets/admin/js/toastr.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('resources/assets/admin/js/common.js') }}"></script>


        <script src="{{ URL::asset('resources/assets/admin/js/jquery-migrate.min.js') }}" type="text/javascript"></script>
        <!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
        <script src="{{ URL::asset('resources/assets/admin/js/jquery-ui.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('resources/assets/admin/js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('resources/assets/admin/js/bootstrap-hover-dropdown.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('resources/assets/admin/js/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('resources/assets/admin/js/jquery.blockui.min.js') }}" type="text/javascript"></script>

        <script src="{{ URL::asset('resources/assets/admin/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>

        <script src="{{ URL::asset('resources/assets/admin/js/metronic.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('resources/assets/admin/js/layout.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('resources/assets/admin/js/quick-sidebar.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('resources/assets/admin/js/demo.js') }}" type="text/javascript"></script>

        
        <script type="text/javascript" src="{{ URL::asset('resources/assets/admin/js/treeview/angular-route.min.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('resources/assets/admin/js/treeview/ui-bootstrap-tpls.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('resources/assets/admin/js/treeview/main.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('resources/assets/admin/js/treeview/handleCtrl.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('resources/assets/admin/js/treeview/nodeCtrl.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('resources/assets/admin/js/treeview/nodesCtrl.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('resources/assets/admin/js/treeview/treeCtrl.js') }}"></script>

        <script type="text/javascript" src="{{ URL::asset('resources/assets/admin/js/treeview/uiTree.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('resources/assets/admin/js/treeview/uiTreeHandle.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('resources/assets/admin/js/treeview/uiTreeNode.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('resources/assets/admin/js/treeview/uiTreeNodes.js') }}"></script>


<script type="text/javascript" src="{{ URL::asset('resources/assets/admin/js/treeview/helper.js') }}"></script>
        <script>
            jQuery(document).ready(function () {
                Metronic.init(); // init metronic core components
                Layout.init(); // init current layout
                QuickSidebar.init(); // init quick sidebar
                Demo.init(); // init demo features
            });
        </script>

        @yield('script')


    </head>
    <span data-us-spinner="{radius:30, width:8, length: 16,scale:0.5}" class="loading-ui-block"> </span>


    <body class="page-header-fixed page-quick-sidebar-over-content page-container-bg-solid">

        <!-- Main navbar -->
        <!-- For Header Start -->
        <!-- BEGIN HEADER -->
        <div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner">
                <!-- BEGIN LOGO -->
                <div class="page-logo">
                    <a href="#">
                        <img src="{{ URL::asset('resources/assets/admin/images/logo.png') }}" alt="logo" class="logo-default" height="20px" width="170px"/>
                    </a>
                    <div class="menu-toggler sidebar-toggler hide">
                        <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
                    </div>
                </div>
                <!-- END LOGO -->
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                </a>
                <!-- END RESPONSIVE MENU TOGGLER -->
                <!-- BEGIN TOP NAVIGATION MENU -->
                <div class="top-menu">
                    <ul class="nav navbar-nav pull-right">
                        <!-- BEGIN NOTIFICATION DROPDOWN -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        <!-- <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <i class="icon-bell"></i>
                                <span class="badge badge-default">
                                    7 </span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="external">
                                    <h3><span class="bold">12 pending</span> notifications</h3>
                                    <a href="#">view all</a>
                                </li>
                                <li>
                                    <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                                        <li>
                                            <a href="javascript:;">
                                                <span class="time">just now</span>
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-success">
                                                        <i class="fa fa-plus"></i>
                                                    </span>
                                                    New user registered. </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <span class="time">3 mins</span>
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-danger">
                                                        <i class="fa fa-bolt"></i>
                                                    </span>
                                                    Server #12 overloaded. </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <span class="time">10 mins</span>
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-warning">
                                                        <i class="fa fa-bell-o"></i>
                                                    </span>
                                                    Server #2 not responding. </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <span class="time">14 hrs</span>
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-info">
                                                        <i class="fa fa-bullhorn"></i>
                                                    </span>
                                                    Application error. </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <span class="time">2 days</span>
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-danger">
                                                        <i class="fa fa-bolt"></i>
                                                    </span>
                                                    Database overloaded 68%. </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <span class="time">3 days</span>
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-danger">
                                                        <i class="fa fa-bolt"></i>
                                                    </span>
                                                    A user IP blocked. </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <span class="time">4 days</span>
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-warning">
                                                        <i class="fa fa-bell-o"></i>
                                                    </span>
                                                    Storage Server #4 not responding dfdfdfd. </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <span class="time">5 days</span>
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-info">
                                                        <i class="fa fa-bullhorn"></i>
                                                    </span>
                                                    System Error. </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <span class="time">9 days</span>
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-danger">
                                                        <i class="fa fa-bolt"></i>
                                                    </span>
                                                    Storage server failed. </span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>    -->
                        <!-- END NOTIFICATION DROPDOWN -->

                        <!-- BEGIN USER LOGIN DROPDOWN -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        <li class="dropdown dropdown-user">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <?php
                                $filename = base_path() . '/' . Constants::$profile_photouploadpath . $userProfilePhoto;
                                if (file_exists($filename) && $userProfilePhoto != '') {
                                    ?>
                                    <img src="<?php echo URL::to('/') . '/' . Constants::$profile_photouploadpath . $userProfilePhoto; ?>" class="img-circle" alt="">
<?php } else { ?>
                                    <img src="{{ URL::asset('resources/assets/admin/images/avatar3_small.jpg') }}" alt=""> 
                                    <?php } ?>

                                <span class="username username-hide-on-mobile">
<?php echo Session()->get('Name'); ?> </span>
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-default">
                                <li><a href="{{URL::to('admin/editprofile',Session()->get('EncryptUserID'))}}"><i class="fa fa-user"></i> My Profile </a></li>
                                <li><a href="{{route('admin_change_password')}}"><i class="fa fa-cog"></i> Change Password </a></li>
                                <li><a href="{{route('logout')}}"><i class="fa fa-sign-out"></i> Log Out </a></li>
                            </ul>
                        </li>
                        <!-- END USER LOGIN DROPDOWN -->
                    </ul>
                </div>
                <!-- END TOP NAVIGATION MENU -->
            </div>
            <!-- END HEADER INNER -->
        </div>
        <!-- END HEADER -->
        <div class="clearfix"></div>
        <div class="page-container">
            <!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
                <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                <div class="page-sidebar navbar-collapse collapse">
                    <!-- BEGIN SIDEBAR MENU -->
                    <ul class="page-sidebar-menu page-sidebar-menu-light" data-keep-expanded="true" data-auto-scroll="true" data-slide-speed="200">

                        <li class="sidebar-toggler-wrapper">
                            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                            <div class="sidebar-toggler">
                            </div>
                            <!-- END SIDEBAR TOGGLER BUTTON -->
                        </li>

                        <li class="<?php
                            if ($action == 'admin_dashboard') {
                                echo "active ";
                            }
                            ?>" >
                            <a href="{{route('admin_dashboard')}}">
                                <i class="icon-home"></i>
                                <span class="title">Dashboard</span>
                                <!-- <span class="selected"></span> -->
                                <!-- <span class="arrow open"></span> -->
                            </a>
                        </li>
                     <?php /*   <li class="<?php
                            if ($action == 'admin_user_add' || $action == 'admin_user_list' || $action == 'admin_user_edit') {
                                echo "active ";
                            }
                            ?>"> 
                            <a href="">
                                <i class="fa fa-users"></i>
                                <span class="title">Users List </span>
                                <!-- <span class="arrow"></span> -->
                            </a>
                            <ul class="sub-menu">
                                <li><a href="{{route('admin_user_list')}}"><i class="fa fa-circle-o"></i> Users List</a></li>
                                <li><a href="{{route('admin_user_add')}}"><i class="fa fa-circle-o"></i> Add User</a></li>
                               
                            </ul> 
                        </li>    */ ?>

                        
                        <li class="<?php
                            if ($action == 'admin_cms_add' || $action == 'admin_cms' || $action == 'admin_cms_edit') {
                                echo "active ";
                            }
                            ?>"> 
                            <a href="">
                                <i class="fa fa-files-o"></i>
                                <span class="title">CMS List </span>
                                <!-- <span class="arrow"></span> -->
                            </a>
                            <ul class="sub-menu">
                                <li class="<?php echo ($action == 'admin_cms_edit' || $action == 'admin_cms') ? 'active' : ''; ?>"><a href="{{route('admin_cms')}}"><i class="fa fa-circle-o"></i> CMS List</a></li>
                                <li class="<?php echo ($action == 'admin_cms_add') ? 'active' : ''; ?>"><a href="{{route('admin_cms_add')}}"><i class="fa fa-circle-o"></i> Add CMS</a></li>
                               
                            </ul> 
                        </li>
							
                        <li class="<?php
                            if ($action == 'navigation') {
                                echo "active ";
                            }
                            ?>"> 
                            <a href="{{route('navigation')}}">
                                <i class="fa fa-arrows"></i>
                                <span class="title">Navigation </span>
                                <!-- <span class="arrow"></span> -->
                            </a>
                            
                        </li> 
						<li class="<?php
                            if ($action == 'admin_portfolio_add' || $action == 'admin_portfolio_list' || $action == 'admin_portfolio_edit') {
                                echo "active ";
                            }
                            ?>"> 
                            <a href="">
                                <i class="fa fa-briefcase"></i>
                                <span class="title">Portfolio List </span>
                                <!-- <span class="arrow"></span> -->
                            </a>
                            <ul class="sub-menu">
                                <li class="<?php echo ($action == 'admin_portfolio_list' || $action == 'admin_portfolio_edit') ? 'active' : ''; ?>"><a href="{{route('admin_portfolio_list')}}"><i class="fa fa-circle-o"></i> Portfolio List</a></li>
                                <li class="<?php echo ($action == 'admin_portfolio_add') ? 'active' : ''; ?>"><a href="{{route('admin_portfolio_add')}}"><i class="fa fa-circle-o"></i> Add Portfolio</a></li>
                               
                            </ul> 
                        </li>	
                        <li class="<?php
                            if ($action == 'admin_setting_add') {
                                echo "active ";
                            }
                            ?>"> 
                            <a href="{{route('admin_setting_add')}}">
                                <i class="fa fa-cog"></i>
                                <span class="title">Setting </span>
                                <!-- <span class="arrow"></span> -->
                            </a>
                            
                        </li>  


                    </ul>
                    <!-- END SIDEBAR MENU -->
                </div>
            </div>
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <div class="page-content">
                    <!-- BEGIN PAGE CONTENT-->
                    @yield('content')
                    <!-- END PAGE CONTENT-->
                </div>
            </div>
            <!-- END CONTENT -->

        </div>


        <!-- Main End -->


        <!-- Footer -->
        <div class="page-footer">
            <div class="page-footer-inner">
                <p>&copy;{{date('Y')}} {{config('app.projectName')}}. All Rights Reserved.</p>
            </div>
            <div class="scroll-to-top" style="display: block;">
                <i class="icon-arrow-up"></i>
            </div>
        </div>

        <!-- /footer -->
    </body>
</html>
