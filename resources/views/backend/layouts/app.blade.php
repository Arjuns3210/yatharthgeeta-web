<!DOCTYPE html>
<html class="loading" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="author" content="MYPCOTINFOTECH">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Admin</title>
    <link rel="shortcut icon" type="image/x-icon" href="../backend/img/logo.png">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700,900%7CMontserrat:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../backend/css/mypcot.min.css">
    <link rel="stylesheet" type="text/css" href="../backend/fonts/feather/style.min.css">
    <link rel="stylesheet" type="text/css" href="../backend/fonts/simple-line-icons/style.css">
    <link rel="stylesheet" type="text/css" href="../backend/fonts/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../backend/vendors/css/perfect-scrollbar.min.css">
    <link rel="stylesheet" type="text/css" href="../backend/vendors/css/prism.min.css">
    <link rel="stylesheet" type="text/css" href="../backend/vendors/css/switchery.min.css">
    <link rel="stylesheet" type="text/css" href="../backend/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../backend/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="../backend/css/colors.css">
    <link rel="stylesheet" type="text/css" href="../backend/css/components.css">
    <link rel="stylesheet" type="text/css" href="../backend/css/themes/layout-dark.css">
    <link rel="stylesheet" href="../backend/css/plugins/switchery.css">
    <link rel="stylesheet" href="../backend/vendors/css/datatables/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="../backend/css/style.css">
    <link rel="stylesheet" type="text/css" href="../backend/css/select2.min.css">
    <!-- added by nikunj -->
    <link rel="stylesheet" type="text/css" href="../backend/css/datepicker.css">
    <script src="../backend/js/jquery-3.2.1.min.js"></script>
    <script src="../backend/vendors/js/core/bootstrap.min.js" type="text/javascript"></script>
    <script src="../backend/vendors/js/vendors.min.js"></script>
    <script src="../backend/vendors/js/datatable/jquery.dataTables.min.js"></script>
    <script src="../backend/vendors/js/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="../backend/js/bootbox.min.js"></script>
    <!-- added by nikunj -->
    <script src="../backend/vendors/js/datepicker.min.js"></script>
</head>
<body class="vertical-layout vertical-menu 2-columns" data-menu="vertical-menu" data-col="2-columns" id="container">
    <nav class="navbar navbar-expand-lg navbar-light header-navbar navbar-fixed mt-2">
        <div class="container-fluid navbar-wrapper">
            <div class="navbar-header d-flex pull-left">
                <div class="navbar-toggle menu-toggle d-xl-none d-block float-left align-items-center justify-content-center" data-toggle="collapse"><i class="ft-menu font-medium-3"></i></div>
                <li class="nav-item mr-2 d-none d-lg-block">
                    {{-- <a class="nav-link apptogglefullscreen" id="navbar-fullscreen" href="javascript:;">
                        <i class="ft-maximize font-medium-3" style="color:black !important"></i>
                    </a> --}}
                </li>

                <h5 class="translateLable padding-top-sm padding-left-sm pt-1"  data-translate="welcome_to_admin_panel">Welcome {{session('data')['name']}}</h5>
            </div>
            <div class="navbar-container pull-right">
                <div class="collapse navbar-collapse d-block" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <div class="d-none d-xl-block">
                            <div class="col-sm-12">
                                <a href="profile" class="mr-1"><span class="mr-1" style="font-size: 24px; color: #aaa;">|</span><i title="Edit Profile" class="fa fa-user-circle-o fa-lg" style="color:brown;"></i></a>

                                <a href="updatePassword"><span class="mr-1" style="font-size: 24px; color: #aaa;">|</span><i title="Change Password" class="fa fa-key fa-lg" style="color:brown;"></i></a>

                                <a href="logout"><span class="mr-1" style="font-size: 24px; color: #aaa;">|</span><i title="Logout" class="fa fa-power-off fa-lg" style="color:brown;"></i></a>
                            </div>
                        </div>
                        <li class="dropdown nav-item d-xl-none d-block"><a id="dropdownBasic3" href="#" data-toggle="dropdown" class="nav-link position-relative dropdown-toggle"><i class="ft-user font-medium-3 blue-grey darken-4"></i>
                            <div class="dropdown-menu text-left dropdown-menu-right m-0 pb-0 dropdownBasic3Content" aria-labelledby="dropdownBasic2">
                                <a class="dropdown-item" href="">
                                    <div class="d-flex align-items-center"><i class="ft-edit mr-2"></i><span>Edit Profile</span></div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="">
                                    <div class="d-flex align-items-center"><i class="ft-edit mr-2"></i><span>Update Password</span></div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout">
                                    <div class="d-flex align-items-center"><i class="ft-power mr-2"></i><span>Logout</span></div>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div class="wrapper">
        <div class="app-sidebar menu-fixed" style="background-image: url(../backend/img/side_nav_bg.png); background-size: cover; background-position: top left;">
            <div class="sidebar-header">
                <div class="logo clearfix">
                    <a class="logo-text float-left" href="dashboard">
                        <div class="logo-img">
                            <img src="../backend/img/logo.png" alt="Logo"/>
                        </div>
                    </a>
                    <a class="nav-toggle d-none d-lg-none d-xl-block is-active" id="sidebarToggle" href="javascript:;"><i class="toggle-icon ft-toggle-right" data-toggle="collapsed"></i></a>
                    <a class="nav-close d-block d-lg-block d-xl-none" id="sidebarClose" href="javascript:;"><i class="ft-x"></i></a>
                </div>
            </div>
            <div class="sidebar-content main-menu-content scroll">
                @php
                //$lastParam =  last(request()->segments());
                //GET OATH :: Request::path()
                    $lastParam =  Request::segment(2);
                    $permissions = Session::get('permissions');
                    $count = count($permissions);
                    $permission_array = array();
                @endphp
                @for($i=0; $i<$count; $i++)
                    @php
                        $permission_array[$i] = $permissions[$i]->codename;
                    @endphp
                @endfor
                <div class="nav-container">
                    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                        <li class="nav-item {{ Request::path() ==  'dashboard' ? 'active' : ''  }}">
                            <a href="dashboard"><i class="ft-home"></i><span class="menu-title" data-i18n="Documentation">Dashboard</span></a>
                        </li>
                        @if(session('data')['role_id'] == 1  ||
                            in_array('books_category', $permission_array)

                        )
                        <li class="has-sub nav-item">
                            <a href="javascript:;" class="dropdown-parent"><i class="ft-grid"></i><span data-i18n="" class="menu-title">Master</span></a>
                            <ul class="menu-content">
                                <li class="{{ $lastParam ==  'books_category' ? 'active' : '' }}">
                                    <a href="books_category" class="menu-item"><i class="fa fa-list-alt"></i>Books Category</a>
                                </li>
                                <li class="{{ $lastParam ==  'books' ? 'active' : '' }}">
                                    <a href="books" class="menu-item"><i class="fa fa-book" aria-hidden="true"></i>Books</a>
                                </li>
                                <li class="{{ $lastParam ==  'ashram' ? 'active' : '' }}">
                                    <a href="ashram" class="menu-item"><i class="fa fa-building-o" aria-hidden="true"></i>Ashram</a>
                                </li>
                                <li class="{{ $lastParam ==  'guru' ? 'active' : '' }}">
                                    <a href="guru" class="menu-item"><i class="fa fa-user-o" aria-hidden="true"></i>Guru's</a>
                                </li>
                                <li class="{{ $lastParam ==  'language' ? 'active' : '' }}">
                                    <a href="language" class="menu-item"><i class="fa fa-language" aria-hidden="true"></i>Language</a>
                                </li>
                                <li class="{{ $lastParam ==  'banners' ? 'active' : '' }}">
                                    <a href="banners" class="menu-item"><i class="fa fa-picture-o" aria-hidden="true"></i>Banners</a>
                                </li>
                                <li class="{{ $lastParam ==  'mantras' ? 'active' : '' }}">
                                    <a href="mantras" class="menu-item"><i class="fa fa-ravelry" aria-hidden="true"></i>Mantras</a>
                                </li>
								<li class="{{ $lastParam ==  'quotes' ? 'active' : '' }}">
                                    <a href="quotes" class="menu-item"><i class="fa fa-quote-left" aria-hidden="true"></i>Quotes</a>
                                </li>
                                <li class="{{ $lastParam ==  'videos' ? 'active' : '' }}">
                                    <a href="videos" class="menu-item"><i class="fa fa-video-camera" aria-hidden="true"></i>Videos</a>
                                </li>
                            </ul>
                        </li>

                        @endif
                        @if(session('data')['role_id'] == 1  ||
                            in_array('role', $permission_array) ||
                            in_array('staff', $permission_array)
                           )
                        <li class="has-sub nav-item">
                            <a href="javascript:;" class="dropdown-parent"><i class="icon-user-following"></i><span data-i18n="" class="menu-title">Staff Management</span></a>
                            <ul class="menu-content">
                                <li class="{{ $lastParam ==  'roles' ? 'active' : '' }}">
                                    <a href="roles" class="menu-item"><i class="fa fa-circle fs_i"></i>Manage Roles</a>
                                </li>
                                <li class="{{ $lastParam ==  'staff' ? 'active' : '' }}">
                                    <a href="staff" class="menu-item"><i class="fa fa-circle fs_i"></i>Manage Staff</a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a href="general_settings"><i class="icon-user-following"></i><span data-i18n="" class="menu-title">General Settings</span></a>
                        </li>
                        @if(session('data')['role_id'] == 1  ||
                            in_array('home_collection', $permission_array)
                        )
                        <li class="has-sub nav-item">
                            <a href="javascript:;" class="dropdown-parent"><i class="ft-grid"></i><span data-i18n="" class="menu-title">Collections</span></a>
                            <ul class="menu-content">
                                <li class="{{ $lastParam ==  'home_collection' ? 'active' : '' }}">
                                    <a href="home_collection" class="menu-item"><i class="fa fa-list-alt"></i>Home</a>
                                </li>
                                <li class="{{ $lastParam ==  'explore_collection' ? 'active' : '' }}">
                                    <a href="explore_collection" class="menu-item"><i class="fa fa-list-alt"></i>Explore</a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        <li class="nav-item {{ $lastParam ==  'logout' ? 'active' : ''  }}">
                            <a href="logout"><i class="fa fa-power-off"></i><span class="menu-title" >Logout</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="main-panel">
            @yield('content')
            <footer class="footer">
                <p class="clearfix text-muted m-0"><span>Copyright &copy; 2023 &nbsp;</span><span class="d-none d-sm-inline-block"> All rights reserved.</span></p>
            </footer>
            <button class="btn btn-primary scroll-top" type="button"><i class="ft-arrow-up"></i></button>
        </div>
        <div class="sidenav-overlay"></div>
        <div class="drag-target"></div>
    </div>
</body>
<script src="../backend/vendors/js/switchery.min.js"></script>
<script src="../backend/js/core/app-menu.js"></script>
<script src="../backend/js/core/app.js"></script>
<script src="../backend/js/notification-sidebar.js"></script>
<script src="../backend/js/customizer.js"></script>
<script src="../backend/js/scroll-top.js"></script>
<script src="../backend/js/scripts.js"></script>
<script src="../backend/js/ajax-custom.js"></script>
<script src="../backend/js/mypcot.min.js"></script>
<script src="../backend/js/select2.min.js"></script>
</html>
